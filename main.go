package main

import (
	"log"
	"os"

	"github.com/codegangsta/cli"
	"github.com/hacdias/wpsync/config"
	"github.com/hacdias/wpsync/helpers/dependencies"
	"github.com/hacdias/wpsync/helpers/plugin"
)

func main() {
	app := cli.NewApp()
	app.Name = "wpsync"
	app.Usage = "Sync WordPress SVN with your Git or SVN repository"
	app.Version = "1.1.0"
	app.Authors = []cli.Author{
		cli.Author{
			Name:  "Henrique Dias",
			Email: "hacdias@gmail.com",
		},
	}
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

		if conf.Bower {
			if _, err := os.Stat("bower.json"); err == nil {
				bower := dependencies.Bower{}
				bower.Update()
			}
		}

		if conf.Composer {
			if _, err := os.Stat("composer.json"); err == nil {
				composer := dependencies.Composer{}
				composer.Update()
			}
		}

		plugin := plugin.Plugin{}
		plugin.Config = conf
		plugin.Update()
	}
	app.Commands = []cli.Command{
		{
			Name:    "init",
			Aliases: []string{"i"},
			Usage:   "init the " + config.File + " file",
			Flags: []cli.Flag{
				cli.StringFlag{
					Name:  "link, l",
					Value: "",
					Usage: "the wordpress svn url",
				},
			},
			Action: func(c *cli.Context) {
				if c.String("link") == "" {
					log.Fatal("please define the wordpress svn link, check \"wpsync init -h\" to know more")
				}

				config.Init(c.String("link"))
			},
		},
	}
	app.Run(os.Args)
}
