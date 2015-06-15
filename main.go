package main

import (
  "./vcs"
)

func main() {
  gitt := vcs.Git{}
  gitt.SetCommit("teste")
  gitt.Update()
}
