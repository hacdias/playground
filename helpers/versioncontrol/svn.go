package versioncontrol

import (
	"errors"
	"os"
	"path"

	"github.com/hacdias/wpsync/helpers/command"
	"github.com/termie/go-shutil"
)

// Svn type for svn objects
type Svn struct {
	Commit, Tag string
}

// Update to update svn repo
func (s Svn) Update() error {
	if s.Commit == "" {
		return errors.New("svn: you haven't mentioned the commit message")
	}

	if s.Tag != "" {
		dir, err := os.Getwd()

		if err != nil {
			return err
		}

		trunk := path.Join(dir, "trunk")
		tags := path.Join(dir, "tags")
		tagfolder := path.Join(tags, s.Tag)
		shutil.CopyTree(trunk, tagfolder, nil)
	}

	command.Run("svn", "add", "--force", ".")
	command.Run("svn", "commit", "-m", s.Commit)

	return nil
}
