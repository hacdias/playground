package action

import (
	"io/ioutil"
	"log"
	"os"
	"strings"

	"github.com/hacdias/wpsync/config"
	"github.com/hacdias/wpsync/helpers/dependencies"
	"github.com/hacdias/wpsync/helpers/plugin"
	"github.com/likexian/simplejson-go"
)

// Options is the type of options for main action of WPSync
type Options struct {
	Bower, Composer   bool
	Increase, Message string
}

// Do does the main action of WPSync
func Do(options Options) {
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

	file, err := ioutil.ReadFile(config.File)

	if err != nil {
		log.Fatal(err)
	}

	json, _ := simplejson.Loads(string(file))

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
