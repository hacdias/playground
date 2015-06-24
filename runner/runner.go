package runner

import (
	"fmt"
	"io/ioutil"
	"log"
	"os"
	"strings"

	"github.com/hacdias/wpsync-cli/config"
	"github.com/hacdias/wpsync-cli/helpers/dependencies"
	"github.com/hacdias/wpsync-cli/helpers/plugin"
)

// Do does the main action of WPSync
func Do(options config.Config) {
	file, err := ioutil.ReadFile(config.File)

	if err != nil {
		log.Fatal(err)
	}

	//@todo: give priority to CLI options like --bower

	fmt.Println(options.Composer)
	os.Exit(0)

	if _, err := os.Stat(config.File); err != nil {
		log.Fatal(err)
	}

	if options.Bower {
		if _, err := os.Stat("bower.json"); err == nil {
			bower := dependencies.Bower{}
			bower.Update()
		}
	}

	if options.Composer {
		if _, err := os.Stat("composer.json"); err == nil {
			composer := dependencies.Composer{}
			composer.Update()
		}
	}

	plugin := plugin.Plugin{}

	if !json.Has("wordpress-svn") {
		log.Fatal("wordpress-svn not defined in .wpsync file")
	}

	plugin.WordpressSvn, _ = json.Get("wordpress-svn").String()

	if strings.Contains(plugin.WordpressSvn, "trunk") {
		plugin.WordpressSvn = strings.Replace(plugin.WordpressSvn, "trunk", "", -1)
	}

	plugin.PluginFile = "plugin.php"
	if json.Has("main") {
		plugin.PluginFile, _ = json.Get("main").String()
	}

	plugin.ReadmeFile = "readme.txt"
	if json.Has("readme") {
		plugin.ReadmeFile, _ = json.Get("readme").String()
	}

	plugin.Index = options.Increase
	if json.Has("increase") && options.Increase == "build" {
		plugin.Index, _ = json.Get("increase").String()
	}

	plugin.FilesIgnore = []string{}
	if json.Has("ignore") {
		fi, _ := json.Get("ignore").Array()
		ignore := make([]string, len(fi))

		for index, content := range fi {
			ignore[index] = content.(string)
		}

		plugin.FilesIgnore = ignore
	}

	plugin.Message = options.Message
	plugin.Update()
}
