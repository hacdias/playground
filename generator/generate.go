package main

import (
	"encoding/json"
	"fmt"
	"io"
	"os"
	"path/filepath"
	"strings"
	"text/tabwriter"

	"github.com/samber/lo"
	"golang.org/x/text/cases"
	"golang.org/x/text/language"
)

func formatFunctionName(name string) string {
	name = strings.TrimPrefix(name, "/")
	name = strings.ReplaceAll(name, "-", "/")
	parts := strings.Split(name, "/")

	parts = lo.Map(parts, func(s string, _ int) string {
		return cases.Title(language.English).String(s)
	})

	return strings.Join(parts, "")
}

func formatVariableName(name, typ string, exported bool) string {
	if typ == "file" {
		return "f"
	}

	name = strings.ReplaceAll(name, "_", " ")
	name = strings.ReplaceAll(name, "-", " ")
	name = strings.ReplaceAll(name, ".", " ")

	parts := strings.Split(name, " ")
	parts = lo.Map(parts, func(s string, i int) string {
		s = strings.ToLower(s)
		if i == 0 && !exported {
			return s
		}
		return cases.Title(language.English).String(s)
	})

	return strings.Join(parts, "")
}

func formatVariableType(typ string) string {
	if typ == "file" {
		return "io.Reader"
	}

	if typ == "array" {
		return "[]string"
	}

	return typ
}

func writeOptionsStruct(w io.Writer, name string, options []*Option) {
	if len(options) == 0 {
		return
	}

	fmt.Fprintf(w, "type %s struct {\n", name)
	tw := tabwriter.NewWriter(w, 4, 4, 2, ' ', tabwriter.TabIndent)

	for _, option := range options {
		if option.Description != "" {
			lines := strings.Split(option.Description, "\n")

			for _, line := range lines {
				line = strings.TrimSpace(line)
				fmt.Fprintf(tw, "\t// %s\n", line)
			}
		}

		name := formatVariableName(option.Name, option.Type, true)
		typ := formatVariableType(option.Type)
		fmt.Fprintf(tw, "\t%s %s", name, typ)
		fmt.Fprintf(tw, "\n")
	}

	tw.Flush()
	fmt.Fprintf(w, "}\n\n")
}

func writeFunction(w io.Writer, endpoint *Endpoint) {
	functionName := formatFunctionName(endpoint.Name)
	optionsName := functionName + "Options"
	args := []string{"ctx context.Context"}

	writeOptionsStruct(w, optionsName, endpoint.Options)

	fmt.Fprintf(w, "func (c *Client) %s(", functionName)

	for _, argument := range endpoint.Arguments {
		name := formatVariableName(argument.Name, argument.Type, false)
		typ := formatVariableType(argument.Type)
		args = append(args, fmt.Sprintf("%s %s", name, typ))
	}

	if len(endpoint.Options) > 0 {
		args = append(args, fmt.Sprintf("options *%s", functionName+"Options"))
	}

	fmt.Fprint(w, strings.Join(args, ", "))
	fmt.Fprintf(w, ") ")

	// TODO: use correct endpoint.Response type.
	// if len(endpoint.Response) > 1 {
	// 	fmt.Fprintf(w, "(")
	// }

	// types := lo.Reduce(endpoint.Response, func(agg []string, a *Argument, _ int) []string {
	// 	agg = append(agg, a.Type)
	// 	return agg
	// }, []string{})

	// fmt.Fprintf(w, "%s", strings.Join(types, ", "))

	// if len(endpoint.Response) > 1 {
	// 	fmt.Fprintf(w, ")")
	// }
	fmt.Fprintf(w, "([]byte, error) {\n")

	fmt.Fprintf(w, "\treq := c.Request(\"%s\")\n", endpoint.Name)

	for _, argument := range endpoint.Arguments {
		if argument.Type == "file" {
			fmt.Fprintf(w, "\treq.FileBody(f)\n")
		} else {
			name := formatVariableName(argument.Name, argument.Type, false)
			fmt.Fprintf(w, "\treq.Arguments(%s)\n", name)
		}
	}

	if len(endpoint.Options) > 0 {
		fmt.Fprintf(w, "\tif options != nil {\n")

		for _, option := range endpoint.Options {
			name := formatVariableName(option.Name, option.Type, true)
			fmt.Fprintf(w, "\t\treq.Option(\"%s\", options.%s)\n", option.Name, name)
		}

		fmt.Fprintf(w, "\t}\n")
	}

	// TODO: options defaults.
	// TODO: variadics.
	// TODO: streaming APIs?

	fmt.Fprintf(w, "\tres, err := req.Send(ctx)\n")
	fmt.Fprintf(w, "\tif err != nil {\n")
	fmt.Fprintf(w, "\t\treturn nil, err\n")
	fmt.Fprintf(w, "\t}\n")
	fmt.Fprintf(w, "\tif res.Error != nil {\n")
	fmt.Fprintf(w, "\t\treturn nil, res.Error\n")
	fmt.Fprintf(w, "\t}\n")

	fmt.Fprintf(w, "\tdefer res.Close()\n")
	fmt.Fprintf(w, "\treturn io.ReadAll(res.Output)\n")

	fmt.Fprintf(w, "}\n\n")
}

func generateGoClient(rpc *RPC, outputDirectory string) error {
	err := os.MkdirAll(outputDirectory, 0766)
	if err != nil {
		return err
	}

	// TODO: copy default code.

	w, err := os.Create(filepath.Join(outputDirectory, "generated.go"))
	if err != nil {
		return err
	}
	defer w.Close()

	fmt.Fprintf(w, "package kubo\n\n")
	fmt.Fprintln(w, "import (")
	fmt.Fprintln(w, "\t\"context\"")
	fmt.Fprintln(w, "\t\"io\"")
	fmt.Fprintf(w, ")\n\n")

	for _, endpoint := range rpc.Endpoints {
		writeFunction(w, endpoint)
	}

	return nil
}

func main() {
	rpc, err := GetRPC()
	if err != nil {
		panic(err)
	}

	js, err := json.MarshalIndent(rpc, "", "  ")
	if err != nil {
		panic(err)
	}

	err = os.WriteFile("../go-client-usage/api.json", js, 0644)
	if err != nil {
		panic(err)
	}

	generateGoClient(rpc, "../go-client/")
}
