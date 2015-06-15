package vcs

import(
	"errors"

	"github.com/hacdias/wp-sync/command"
)

type Git struct {
	commit, tag string
}

func (g *Git) SetCommit(commit string) {
	g.commit = commit
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
