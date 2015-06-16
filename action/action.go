package action

import (
	"io/ioutil"
	"log"
	"os"
	"strings"

	"github.com/hacdias/wp-sync/config"
	"github.com/hacdias/wp-sync/helpers/dependencies"
	"github.com/hacdias/wp-sync/helpers/plugin"
	"github.com/likexian/simplejson-go"
)

// Do is
func Do() {
	if _, err := os.Stat(config.File); err != nil {
		log.Fatal(err)
	}

	if _, err := os.Stat("composer.json"); err == nil {
		composer := dependencies.Composer{}
		composer.Update()
	}

	if _, err := os.Stat("bower.json"); err == nil {
		bower := dependencies.Bower{}
		bower.Update()
	}

	file, err := ioutil.ReadFile(config.File)

	if err != nil {
		log.Fatal(err)
	}

	json, _ := simplejson.Loads(string(file))

	plugin := plugin.Plugin{}

	if !json.Has("wordpress-svn") {
		log.Fatal("you haven't defined the WordPress SVN url")
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

	plugin.Index = "build"
	if json.Has("increase") {
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

	plugin.Update()
}
