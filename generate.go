package main

import (
	"encoding/json"
	"fmt"
	"os"
	"strings"
	"text/tabwriter"

	"github.com/samber/lo"
	"golang.org/x/text/cases"
	"golang.org/x/text/language"
)

func endpointNameToFunctionName(name string) string {
	name = strings.TrimPrefix(name, "/")
	name = strings.ReplaceAll(name, "-", "/")
	parts := strings.Split(name, "/")

	parts = lo.Map(parts, func(s string, _ int) string {
		return cases.Title(language.English).String(s)
	})

	return strings.Join(parts, "")
}

func formatArgument(arg *Argument, exported bool) (string, string) {
	if arg.Type == "file" {
		return "r", "io.Reader"
	}

	if arg.Type == "array" {
		arg.Type = "[]string"
	}

	name := strings.ReplaceAll(arg.Name, "_", " ")
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

	return strings.Join(parts, ""), arg.Type
}

func main() {
	rpc := GetRPC()

	err := os.MkdirAll("gen/", 0766)
	if err != nil {
		panic(err)
	}

	js, err := json.MarshalIndent(rpc, "", "  ")
	if err != nil {
		panic(err)
	}

	err = os.WriteFile("gen/api.json", js, 0644)
	if err != nil {
		panic(err)
	}

	w, err := os.Create("gen/api.go")
	if err != nil {
		panic(err)
	}

	fmt.Fprintf(w, "package main\n\n")
	fmt.Fprintln(w, "import (")
	fmt.Fprintln(w, "\t\"context\"")
	fmt.Fprintln(w, "\t\"io\"")
	fmt.Fprintf(w, ")\n\n")
	fmt.Fprintf(w, "type Client struct {\n}\n\n")

	for _, endpoint := range rpc.Endpoints {
		functionName := endpointNameToFunctionName(endpoint.Name)
		optionsName := functionName + "Options"
		args := []string{"ctx context.Context"}

		if len(endpoint.Options) > 0 {
			tw := tabwriter.NewWriter(w, 4, 4, 2, ' ', tabwriter.TabIndent)

			fmt.Fprintf(w, "type %s struct {\n", optionsName)
			for _, option := range endpoint.Options {
				n, t := formatArgument(option, true)
				fmt.Fprintf(tw, "\t%s\t%s", n, t)
				if option.Description != "" {
					fmt.Fprintf(tw, "\t// %s", strings.ReplaceAll(option.Description, "\n", " "))
				}
				fmt.Fprintf(tw, "\n")
			}

			tw.Flush()

			fmt.Fprintf(w, "}\n\n")
		}

		fmt.Fprintf(w, "func (c *Client) %s(", functionName)

		for _, argument := range endpoint.Arguments {
			n, t := formatArgument(argument, false)
			args = append(args, fmt.Sprintf("%s %s", n, t))
		}

		if len(endpoint.Options) > 0 {
			args = append(args, fmt.Sprintf("options *%s", functionName+"Options"))
		}

		fmt.Fprint(w, strings.Join(args, ", "))
		fmt.Fprintf(w, ") ")

		if len(endpoint.Response) > 1 {
			fmt.Fprintf(w, "(")
		}

		types := lo.Reduce(endpoint.Response, func(agg []string, a *Argument, _ int) []string {
			agg = append(agg, a.Type)
			return agg
		}, []string{})

		fmt.Fprintf(w, "%s", strings.Join(types, ", "))

		if len(endpoint.Response) > 1 {
			fmt.Fprintf(w, ")")
		}

		fmt.Fprintf(w, " {\n")
		fmt.Fprintf(w, "\t// TODO: body, return\n\treturn nil\n")
		fmt.Fprintf(w, "}\n\n")
	}

}
