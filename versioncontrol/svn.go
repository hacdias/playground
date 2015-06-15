package vcs

import(
  "../helpers"
  "errors"
  "path"
  "log"
  "os"

  "github.com/termie/go-shutil"
)

type Svn struct {
  commit, tag string
}

func Update(s Svn) (bool) {
  if s.commit == "" {
    errors.New("svn: you haven't mentioned the commit message")
    return false
  }

  if s.tag != "" {
    dir, err := os.Getwd()

    if err != nil {
      log.Fatal(err)
      return false
    }

    trunk := path.Join(dir, "trunk")
    tags := path.Join(dir, "tags")
    tagfolder := path.Join(tags, s.tag)
    helpers.CopyFolder(trunk, tagfolder)
  }

  helpers.Run("svn", "add", "*", "--force")
  helpers.Run("svn", "commit", "-m", "\"" + s.commit + "\"")

  return true
}
