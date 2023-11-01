package main

import (
	"crypto/md5"
	"crypto/sha1"
	"crypto/sha256"
	"crypto/sha512"
	"encoding/hex"
	"encoding/json"
	"fmt"
	"io/ioutil"
	"log"
	"os"
	"path/filepath"

	"github.com/spf13/cobra"
)

var (
	recursive                         bool
	doMD5, doSHA1, doSHA256, doSHA512 bool
	hashes                            map[string]map[string]string
)

func main() {
	hashes = map[string]map[string]string{}

	var cmd = &cobra.Command{
		Use:   "hasher [file or directory]",
		Short: "generate an hash from a file and prints in json format",
		Run: func(cmd *cobra.Command, args []string) {
			if len(args) == 0 {
				cmd.Help()
				return
			}

			file, err := os.Stat(args[0])

			if err != nil {
				log.Fatal(err)
			}

			if file.IsDir() {
				if recursive {
					filepath.Walk(args[0], func(path string, info os.FileInfo, err error) error {
						if err != nil {
							return err
						}

						if info.IsDir() {
							return nil
						}

						hashFile(path)
						return nil
					})
				} else {
					files, err := ioutil.ReadDir(args[0])

					if err != nil {
						log.Fatal(err)
					}

					for _, file := range files {
						if file.IsDir() {
							continue
						}

						hashFile(file.Name())
					}
				}
			} else {
				hashFile(args[0])
			}

			jsonContent, err := json.MarshalIndent(hashes, "", "\t")

			if err != nil {
				log.Fatal(err)
			}

			fmt.Println(string(jsonContent))
		},
	}

	cmd.Flags().BoolVarP(&recursive, "recursive", "r", false, "iterate the directory recursively")

	cmd.Flags().BoolVarP(&doMD5, "md5", "", false, "get the MD5 hash")
	cmd.Flags().BoolVarP(&doSHA1, "sha1", "", false, "get the SHA1 hash")
	cmd.Flags().BoolVarP(&doSHA256, "sha256", "", false, "get the SHA256 hash")
	cmd.Flags().BoolVarP(&doSHA512, "sha512", "", false, "get the SHA512 hash")
	cmd.Execute()
}

func hashFile(path string) {
	hashes[path] = map[string]string{}

	file, err := ioutil.ReadFile(path)

	if err != nil {
		log.Fatal(err)
	}

	if doMD5 {
		hasher := md5.New()
		hasher.Write(file)
		hashes[path]["md5"] = hex.EncodeToString(hasher.Sum(nil))
	}

	if doSHA1 {
		hasher := sha1.New()
		hasher.Write(file)
		hashes[path]["sha1"] = hex.EncodeToString(hasher.Sum(nil))
	}

	if doSHA256 {
		hasher := sha256.New()
		hasher.Write(file)
		hashes[path]["sha256"] = hex.EncodeToString(hasher.Sum(nil))
	}

	if doSHA512 {
		hasher := sha512.New()
		hasher.Write(file)
		hashes[path]["sha512"] = hex.EncodeToString(hasher.Sum(nil))
	}
}
