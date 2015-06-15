package versioncontrol

import(
	"errors"

	"github.com/hacdias/wp-sync/command"
)

type Git struct {
	Commit, Tag string
}

func (g Git) Update() error {
	if g.commit == "" {
		return errors.New("git: you haven't mentioned the commit message")
	}

	command.Run("git", "add", "-A")

	if g.tag != "" {
		command.Run("git", "tag", g.tag)
	}

	command.Run("git", "commit", "-m", g.commit)
	command.Run("git", "push", "origin", "master")

	if g.tag != "" {
		command.Run("git", "push", "--tags")
	}

	return nil
}
