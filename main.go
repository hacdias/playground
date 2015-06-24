package main

import (
	"os"

	"github.com/codegangsta/cli"
	"github.com/hacdias/wpsync-cli/config"
	"github.com/hacdias/wpsync-cli/runner"
)

func main() {
	app := cli.NewApp()
	app.Name = config.Name
	app.Usage = config.Usage
	app.Version = config.Version
	app.Flags = []cli.Flag{
		cli.BoolTFlag{
			Name:  "bower, b",
			Usage: "update bower dependencies",
		},
		cli.BoolTFlag{
			Name:  "composer, c",
			Usage: "update composer dependencies",
		},
		cli.StringFlag{
			Name:  "increase, i",
			Value: "build",
			Usage: "version increase (major.minor.build.revision)",
		},
		cli.StringFlag{
			Name:  "message, m",
			Value: "",
			Usage: "commit message (default is the version number)",
		},
	}
	app.Action = func(c *cli.Context) {
		conf := config.GetConfig()

		if c.IsSet("bower") {
			conf.Bower = c.BoolT("bower")
		}

		if c.IsSet("composer") {
			conf.Composer = c.BoolT("composer")
		}

		if c.IsSet("increase") {
			conf.Increase = c.String("increase")
		}

		if c.IsSet("message") {
			conf.Message = c.String("message")
		}

		runner.Do(conf)
	}
	app.Run(os.Args)
}
