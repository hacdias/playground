package dependencies

import (
	"io/ioutil"
	"log"
	"os"

	"github.com/hacdias/wp-sync/helpers/command"
	"github.com/likexian/simplejson-go"
)

// Bower is a type for Bower objects
type Bower struct {
	folder string
}

// Update updates bower dependencies
func (b Bower) Update() {
	b.checkFolder()
	os.RemoveAll(b.folder)
	command.Run("bower", "install")
}

func (b *Bower) checkFolder() error {
	b.folder = "bower_components"

	if _, err := os.Stat(".bowerrc"); err == nil {
		file, err := ioutil.ReadFile(".bowerrc")

		if err != nil {
			log.Fatal(err)
		}

		json, _ := simplejson.Loads(string(file))

		if json.Has("directory") {
			b.folder, _ = json.Get("directory").String()
		}
	}

	return nil
}
