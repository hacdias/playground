package config

import (
	"encoding/json"
	"io/ioutil"
	"log"
	"os"
	"path/filepath"

	"github.com/likexian/simplejson-go"
)

const (
	// File is the name of the configuration file of WPSync
	File = "wpsync.json"
)

func init() {
	log.SetFlags(0)
}

// Config is the type of options for main action of WPSync
type Config struct {
	Increase, File, Readme, Svn, Message string
	Bower, Composer, Keep                bool
	Ignore                               []string
}

// GetConfig is used to get the configuration from config.File
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

type jsonFile struct {
	Increase string `json:"increase"`
	Plugin   struct {
		File string `json:"file"`
		Svn  string `json:"svn"`
	} `json:"plugin"`
	Dependencies struct {
		Bower    bool `json:"bower"`
		Composer bool `json:"composer"`
	} `json:"dependencies"`
	Ignore []string `json:"ignore"`
}

// Init configures the config.File
func Init(svn string) {
	confFile := jsonFile{}
	confFile.Increase = "build"
	confFile.Plugin.File = "plugin.php"
	confFile.Plugin.Svn = svn
	confFile.Dependencies.Bower = false
	confFile.Dependencies.Composer = false
	confFile.Ignore = []string{".git", File}

	if _, err := os.Stat("bower.json"); err == nil {
		confFile.Dependencies.Bower = true
	}

	if _, err := os.Stat("composer.json"); err == nil {
		confFile.Dependencies.Composer = true
	}

	if path, err := os.Getwd(); err == nil {
		_, file := filepath.Split(path)

		if _, err := os.Stat(file + ".php"); err == nil {
			confFile.Plugin.File = file + ".php"
		}
	}

	json, err := json.MarshalIndent(confFile, "", "	")

	if err != nil {
		log.Fatal(err)
	}

	err = ioutil.WriteFile(File, json, 0777)

	if err != nil {
		log.Fatal(err)
	}
}
