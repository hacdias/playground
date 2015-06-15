package command

import (
  "os"
  "os/exec"
  "fmt"
)

func Run(command string, args ...string) err {
  cmd := exec.Command(command, args...)
  cmd.Stdin = os.Stdin;
  cmd.Stdout = os.Stdout;
  cmd.Stderr = os.Stderr;
  return cmd.Run()
}
