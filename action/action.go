package action

import (
	"encoding/json"
	"io/ioutil"
	"log"
	"os"
	"strings"

	"github.com/hacdias/wp-sync/config"
	"github.com/hacdias/wp-sync/helpers/dependencies"
	"github.com/hacdias/wp-sync/helpers/plugin"
)

// Do is
func Do() {
	if _, err := os.Stat(config.File); err != nil {
		log.Fatal(err)
	}

	var data interface{}
	file, err := ioutil.ReadFile(config.File)

	if err != nil {
		log.Fatal(err)
	}

	err = json.Unmarshal(file, &data)

	if err != nil {
		log.Fatal(err)
	}

	info := data.(map[string]interface{})

	if info["wordpress-svn"] == nil {
		log.Fatal("you haven't defined the WordPress SVN url")
	}

	wordpressSvn := info["wordpress-svn"].(string)

	if strings.Contains(wordpressSvn, "trunk") {
		wordpressSvn = strings.Replace(wordpressSvn, "trunk", "", -1)
	}

	if _, err := os.Stat("composer.json"); err == nil {
		composer := dependencies.Composer{}
		composer.Update()
	}

	if _, err := os.Stat("bower.json"); err == nil {
		bower := dependencies.Bower{}
		bower.Update()
	}

	plugin := plugin.Plugin{}

	plugin.PluginFile = "plugin.php"
	if info["main"] != nil {
		plugin.PluginFile = info["main"].(string)
	}

	plugin.Index = "build"
	if info["increase"] != nil {
		plugin.Index = info["increase"].(string)
	}

	plugin.FilesIgnore = []string{}
	if info["ignore"] != nil {
		plugin.FilesIgnore = info["ignore"].([string]string)
	}

	plugin.Update()
}
