package config

import (
	"io/ioutil"
	"log"

	"github.com/likexian/simplejson-go"
)

const (
	// File is
	File = "wpsync.json"
	// Name is
	Name = "wpsync"
	// Usage is
	Usage = "Sync WordPress SVN with your Git or SVN repository"
	// Version is
	Version = "1.0.0"
)

func init() {
	log.SetFlags(0)
}

// Config is the type of options for main action of WPSync
type Config struct {
	Increase, File, Readme, Svn, Message string
	Bower, Composer                      bool
	Ignore                               []string
}

// GetConfig is used to get the configuration
func GetConfig() Config {
	file, err := ioutil.ReadFile(File)

	if err != nil {
		log.Fatal(err)
	}

	json, _ := simplejson.Loads(string(file))

	config := Config{}
	config.Increase = "build"
	config.File = "plugin.php"
	config.Readme = "readme.txt"
	config.Bower = true
	config.Composer = true
	config.Message = ""

	if json.Has("increase") {
		config.Increase, _ = json.Get("increase").String()
	}

	if !json.Has("plugin") {
		log.Fatal("plugin section not defined in " + File)
	}

	plugin := json.Get("plugin")

	if plugin.Has("file") {
		config.File, _ = plugin.Get("file").String()
	}

	if !plugin.Has("svn") {
		log.Fatal("wordpress svn link not defined in " + File)
	}

	config.Svn, _ = plugin.Get("svn").String()

	if json.Has("dependencies") {
		dependencies := json.Get("dependencies")

		if dependencies.Has("bower") {
			config.Bower, _ = dependencies.Get("bower").Bool()
		}

		if dependencies.Has("composer") {
			config.Composer, _ = dependencies.Get("composer").Bool()
		}
	}

	if json.Has("ignore") {
		fi, _ := json.Get("ignore").Array()
		ignore := make([]string, len(fi))

		for index, content := range fi {
			ignore[index] = content.(string)
		}

		config.Ignore = ignore
	}

	return config
}
