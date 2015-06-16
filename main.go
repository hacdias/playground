package main

import (
	"os"

	"github.com/codegangsta/cli"
)

func main() {
	app := cli.NewApp()
	app.Name = "wpsync"
	app.Usage = ""
	app.Version = "1.0.0"
	app.Commands = []cli.Command{
		{
			Name:    "init",
			Aliases: []string{"i"},
			Usage:   "",
			Action: func(c *cli.Context) {
				println("Your trying to init a file")
			},
		},
	}
	app.Action = func(c *cli.Context) {
		println("Main action")
	}
	app.Run(os.Args)
}

/*  config_file = 'wpsync.json'
    if not os.path.isfile(config_file):
        print('There is no configuration file.')
        exit(1)

    config = json.loads(open(config_file).read())

    if 'plugin' not in config:
        print('You have problems in the configuration file.')
        exit(1)

    if 'wordpress-svn' not in config:
        print("You haven't defined the WordPress SVN link.")
        exit(1)

    if 'trunk' in config['wordpress-svn']:
        print('Please remove "trunk" from the SVN link.')
        exit(1)

    if os.path.isfile('composer.json'):
        composer = Composer()
        composer.update()

    if os.path.isfile('bower.json'):
        bower = Bower()
        bower.update()

    plugin = Plugin()
    plugin.plugin_file = config['plugin']['main'] if 'main' in config['plugin'] else 'plugin.php'
    plugin.index = config['increase'] if 'increase' in config else 'build'

    if os.path.isdir('.svn'):
        plugin.version_control = 'svn'

    plugin.wordpress_svn = config['wordpress-svn']

    if 'ignore' in config:
        plugin.ignore_files = config['ignore']

    plugin.update()

    try:
        input("Press any key to continue...")
    except SyntaxError:
        pass
*/
