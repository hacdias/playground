package main

import (
	"crypto/sha256"
	"encoding/hex"
	"fmt"
	"io"
	"io/ioutil"
	"log"
	"os"
)

func main() {
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
}
