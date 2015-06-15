package versioncontrol

import (
	"errors"

	"github.com/hacdias/wp-sync/command"
)

// Git type for Git objects
type Git struct {
	Commit, Tag string
}

// Update to update the cwd repo
func (g Git) Update() error {
	if g.Commit == "" {
		return errors.New("git: you haven't mentioned the commit message")
	}

	command.Run("git", "add", "-A")

	if g.Tag != "" {
		command.Run("git", "tag", g.Tag)
	}

	command.Run("git", "commit", "-m", g.Commit)
	command.Run("git", "push", "origin", "master")

	if g.Tag != "" {
		command.Run("git", "push", "--tags")
	}

	return nil
}
