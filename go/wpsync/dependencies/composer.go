package dependencies

import (
	"io/ioutil"
	"log"
	"os"

	"github.com/hacdias/wpsync/command"
	"github.com/likexian/simplejson-go"
)

// Composer is the type for composer dependencies manager object
type Composer struct {
	folder string
}

// Update updates the composer dependencies
func (c Composer) Update() {
	c.checkFolder()

	if _, err := os.Stat("composer.lock"); err == nil {
		os.Remove("composer.lock")
	}

	if _, err := os.Stat(c.folder); err == nil {
		os.RemoveAll(c.folder)
	}

	command.Run("composer", "install")
}

func (c *Composer) checkFolder() error {
	c.folder = "vendor"

	file, err := ioutil.ReadFile("composer.json")

	if err != nil {
		log.Fatal(err)
	}

	json, _ := simplejson.Loads(string(file))

	if json.Has("config") {
		config := json.Get("config")

		if config.Has("vendor-dir") {
			c.folder, _ = config.Get("vendor-dir").String()
		}
	}

	return nil
}
