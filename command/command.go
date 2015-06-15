package command

import (
  "os"
  "os/exec"
  "fmt"
)

func Run(command string, args ...string) {
  cmd := exec.Command(command, args...)
  cmd.Stdin = os.Stdin;
  cmd.Stdout = os.Stdout;
  cmd.Stderr = os.Stderr;
  err := cmd.Run()
  if err != nil {
      fmt.Printf("%v\n", err)
  }
}
