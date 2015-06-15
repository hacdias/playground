package dep

import(
  "../helpers"
  "encoding/json"
  "os"
  "log"
  "io/ioutil"
)

type Bower struct {
  folder string "bower_components"
}

func (b Bower) Update() bool {
  b.CheckFolder()

  helpers.Run("bower", "install")

  if _, err := os.Stat(b.folder); err == nil {
    helpers.Run("bower", "update")
  }

  return true;
}

func (b *Bower) CheckFolder() {
  if _, err := os.Stat(".bowerrc"); err == nil {
    var data interface{}
    file, err := ioutil.ReadFile(".bowerrc")

    if err != nil {
        log.Fatal(err)
    }

    err = json.Unmarshal(file, &data)

    if err != nil {
        log.Fatal(err)
    }

    info := data.(map[string]interface{})

    if info["directory"] != nil {
      b.folder = info["directory"].(string)
    }
  }
}


/*



    def update(self):
      */
