package main

import (
	"crypto/sha256"
	"encoding/hex"
	"fmt"
	"io"
	"io/ioutil"
	"log"
	"os"

	"github.com/spf13/cobra"
)

var (
	wholeDirectory bool
	recursive      bool
	json           bool
)

func main() {
	var cmd = &cobra.Command{
		Use:   "hasher",
		Short: "generate an hash from a file",
		Run: func(cmd *cobra.Command, args []string) {
			cmd.Help()
		},
	}

	var cmdSha256 = &cobra.Command{
		Use:   "sha256 [string to echo]",
		Short: "generates a SHA256 from a given file or directory",
		Run: func(cmd *cobra.Command, args []string) {
			files, _ := ioutil.ReadDir("./")
			for _, f := range files {
				fmt.Print(f.Name() + " : ")

				hasher := sha256.New()
				f, err := os.Open(f.Name())
				if err != nil {
					log.Fatal(err)
				}
				defer f.Close()
				if _, err := io.Copy(hasher, f); err != nil {
					log.Fatal(err)
				}

				fmt.Println(hex.EncodeToString(hasher.Sum(nil)))
			}
		},
	}

	cmd.Flags().BoolVarP(&wholeDirectory, "all", "a", false, "iterate all files in directory")
	cmd.Flags().BoolVarP(&recursive, "recursive", "r", false, "iterate the directory recursively")
	cmd.Flags().BoolVarP(&json, "json", "j", true, "output in json format")
	cmd.AddCommand(cmdSha256)
	cmd.Execute()
}
