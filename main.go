package main

import (
	"os"

	"github.com/codegangsta/cli"
	"github.com/hacdias/wpsync/action"
)

func main() {
	app := cli.NewApp()
	app.Name = "wpsync"
	app.Usage = ""
	app.Version = "1.0.0"
	/*app.Commands = []cli.Command{
		{
			Name:    "init",
			Aliases: []string{"i"},
			Usage:   "",
			Action: func(c *cli.Context) {
				// init
			},
		},
	} */
	app.Action = func(c *cli.Context) {
		action.Do()
	}
	app.Run(os.Args)
}
