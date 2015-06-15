package dependencies

import (
	"encoding/json"
	"io/ioutil"
	"os"

	"github.com/hacdias/wp-sync/command"
)

// Bower is a type for Bower objects
type Bower struct {
	folder string `string:"bower_components"`
}

// Update is used to update bower dependencies
func (b Bower) Update() error {
	b.checkFolder()

	command.Run("bower", "install")
	_, err := os.Stat(b.folder)

	if err == nil {
		command.Run("bower", "update")
	}

	return err
}

func (b *Bower) checkFolder() error {
	if _, err := os.Stat(".bowerrc"); err == nil {
		var data interface{}
		file, err := ioutil.ReadFile(".bowerrc")

		if err != nil {
			return err
		}

		err = json.Unmarshal(file, &data)

		if err != nil {
			return err
		}

		info := data.(map[string]interface{})

		if info["directory"] != nil {
			b.folder = info["directory"].(string)
		}
	}

	return nil
}
