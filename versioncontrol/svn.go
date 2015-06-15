package versioncontrol

import(
  "errors"
  "path"
  "log"
  "os"

  "github.com/hacdias/wp-sync/command"
  "github.com/termie/go-shutil"
)

type Svn struct {
  Commit, Tag string
}

func Update(s Svn) error {
  if s.commit == "" {
    return errors.New("svn: you haven't mentioned the commit message")
  }

  if s.tag != "" {
    dir, err := os.Getwd()

    if err != nil {
      return err
    }

    trunk := path.Join(dir, "trunk")
    tags := path.Join(dir, "tags")
    tagfolder := path.Join(tags, s.tag)
    helpers.CopyFolder(trunk, tagfolder)
  }

  helpers.Run("svn", "add", "*", "--force")
  helpers.Run("svn", "commit", "-m", "\"" + s.commit + "\"")

  return nil
}
