package dependencies

import (
	"encoding/json"
	"io/ioutil"
	"os"

	"github.com/hacdias/wp-sync/command"
)

// Composer type
type Composer struct {
	folder string `string:"vendor"`
}

func (c *Composer) checkFolder() error {
	if _, err := os.Stat("composer.json"); err == nil {
		var data interface{}
		file, err := ioutil.ReadFile("composer.json")

		if err != nil {
			return err
		}

		err = json.Unmarshal(file, &data)

		if err != nil {
			return err
		}

		info := data.(map[string]interface{})

		if info["config"] != nil {
			config := info["config"].(map[string]interface{})

			if config["vendor-dir"] != nil {
				c.folder = config["vendor-dir"].(string)
			}
		}
	}

	return nil
}

// Update asa
func (c Composer) Update() {
	if _, err := os.Stat("composer.lock"); err == nil {
		os.Remove("composer.lock")
	}

	if _, err := os.Stat(c.folder); err == nil {
		os.RemoveAll(c.folder)
	}

	command.Run("composer", "install")
}
