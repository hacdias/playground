package main

import (
	"fmt"
	"reflect"
	"sort"
	"strings"

	cmds "github.com/ipfs/go-ipfs-cmds"
	corecmds "github.com/ipfs/kubo/core/commands"
	"github.com/samber/lo"
)

var ignoreEndpoints = []string{}

var ignoreOptionsPerEndpoint = map[string]map[string]struct{}{
	"/api/v0/add": {
		cmds.RecLong:     struct{}{},
		cmds.DerefLong:   struct{}{},
		cmds.StdinName:   struct{}{},
		cmds.Hidden:      struct{}{},
		cmds.Ignore:      struct{}{},
		cmds.IgnoreRules: struct{}{},
	},
}

func GetRPC() (*RPC, error) {
	endpoints, err := getEndpoints("", corecmds.Root)
	if err != nil {
		return nil, err
	}
	return &RPC{
		Endpoints: endpoints,
	}, nil
}

func parseArgument(arg cmds.Argument) *Argument {
	// TODO: here we need some annotations to know what the string actually is.
	// Is it a CID? Is it a multiaddress? Is it just a string?
	argType := "string"
	if arg.Type == cmds.ArgFile {
		argType = "file"
	}

	return &Argument{
		Name:        arg.Name,
		Type:        argType,
		Required:    arg.Required,
		Variadic:    arg.Variadic,
		Description: arg.Description,
	}
}

func parseOption(opt cmds.Option) *Option {
	def := fmt.Sprint(opt.Default())
	if def == "<nil>" {
		def = ""
	}

	return &Option{
		Name:        opt.Names()[0], // TODO: opt.Name()?
		Type:        opt.Type().String(),
		Description: opt.Description(),
		Default:     def,
	}
}

func getEndpoints(prefix string, cmd *cmds.Command) ([]*Endpoint, error) {
	// Only get commands that are active. Deprecated, experimental and removed
	// commands are not exported.
	if cmd.Status != cmds.Active {
		return nil, nil
	}

	var (
		endpoints []*Endpoint
		arguments []*Argument
		options   []*Option
		response  *Response
	)

	ignore := cmd.Run == nil || lo.Contains(ignoreEndpoints, prefix)
	if !ignore {
		// Parse arguments.
		for _, arg := range cmd.Arguments {
			arguments = append(arguments, parseArgument(arg))
		}

		// Parse options.
		for _, opt := range cmd.Options {
			// Check if option is ignored for this endpoint.
			if ignoreOpts, ok := ignoreOptionsPerEndpoint[prefix]; ok {
				if _, ok := ignoreOpts[opt.Names()[0]]; ok {
					continue
				}
			}

			options = append(options, parseOption(opt))
		}

		if cmd.Type != nil {
			e := reflect.ValueOf(cmd.Type)

			// Defer pointers.
			if e.Type().Kind() == reflect.Pointer || e.Type().Kind() == reflect.Interface {
				e = e.Elem()
			}

			switch e.Type().Kind() {
			case reflect.Slice:
				response = &Response{}
				// TODO: handle
			case reflect.Map:
				response = &Response{}
				// TODO: handle
			case reflect.Struct:
				response = &Response{}
				// TODO: handle

				// fmt.Println(prefix)

				// for i := 0; i < e.NumField(); i++ {
				// 	if e.Type().Field(i).IsExported() {
				// 		varName := e.Type().Field(i).Name
				// 		varType := e.Type().Field(i).Type
				// 		// varValue := e.Field(i).Interface()
				// 		fmt.Printf("%v %v\n", varName, varType)

				// 		response = append(response, &Argument{
				// 			Name: varName,
				// 			Type: varType.String(),
				// 		})

				// 	}
				// }

			default:
				return nil, fmt.Errorf("return type unknown: %v of %s", e.Type().Kind(), e.Type().Name())
			}
		}

		endpoints = []*Endpoint{
			{
				Name:        strings.TrimPrefix(prefix, "/"),
				Description: cmd.Helptext.Tagline,
				Arguments:   arguments,
				Options:     options,
				Response:    response,
			},
		}
	}

	for n, cmd := range cmd.Subcommands {
		child, err := getEndpoints(fmt.Sprintf("%s/%s", prefix, n), cmd)
		if err != nil {
			return nil, err
		}
		endpoints = append(endpoints, child...)
	}

	sort.SliceStable(endpoints, func(i, j int) bool {
		return endpoints[i].Name < endpoints[j].Name
	})

	return endpoints, nil
}
