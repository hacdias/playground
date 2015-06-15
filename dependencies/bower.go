package dependencies

import(
  "encoding/json"
  "os"
  "log"
  "io/ioutil"

  "github.com/hacdias/wp-sync/command"
)

type Bower struct {
  folder string "bower_components"
}

func (b Bower) Update() error {
  b.CheckFolder()

  command.Run("bower", "install")

  if _, err := os.Stat(b.folder); err == nil {
    command.Run("bower", "update")
  }

  return err;
}

func (b *Bower) CheckFolder() error {
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
