package vcs

import(
  "../helpers"
  "errors"
)

type Git struct {
  commit, tag string
}

func (g *Git) SetCommit(commit string) {
    g.commit = commit
}

func (g Git) Update() bool {
  if g.commit == "" {
    errors.New("git: you haven't mentioned the commit message")
    return false
  }

  helpers.Run("git", "add", "-A")

  if g.tag != "" {
    helpers.Run("git", "tag", g.tag)
  }

  helpers.Run("git", "commit", "-m", "\"" + g.commit + "\"")
  helpers.Run("git", "push")

  if g.tag != "" {
    helpers.Run("git", "push", "--tags")
  }

  return true
}
