package main

import (
	"flag"
	"fmt"
	"net/http"
	"os"
	"strconv"
)

var (
	tags  string
	serve bool
	port  int
	help  bool
)

func init() {
	flag.Usage = func() {
		// TODO: review this
		fmt.Println("Journal usage:")
		fmt.Println("")
		flag.PrintDefaults()
		fmt.Println("")
		fmt.Println("Brought to you by Fábio Ferreira and Henrique Dias.")
	}

	flag.StringVar(&tags, "tags", "", "set the tags for this entry separated by spaces")
	flag.BoolVar(&serve, "serve", false, "run the journal as a webserver")
	flag.BoolVar(&help, "help", false, "get help")
	flag.IntVar(&port, "port", 8080, "webserver port for journal")
}

func main() {
	flag.Parse()

	// Check if 'serve' is being used with more flags
	// if so, close the program and show an error message
	if (serve && help) || (serve && len(tags) > 0) {
		fmt.Println("cannot use 'serve' flag with other flags")
		os.Exit(0)
	}

	// If serving is enabled, start a webserver at the defined
	// port. By default it's 8080
	if serve {
		http.HandleFunc("/", serveHTTP)
		http.ListenAndServe(":"+strconv.Itoa(port), nil)
		return
	}

	// If the flag 'help' is true, show the usage for the user
	if help {
		flag.Usage()
		os.Exit(0)
	}

	// TODO: check if notebook file already exists
	// The notebook file link should be at %userprofile%/.journal
	// if it doesn't, ask the user to create a new file
	// We'll do the encryption later
}

func serveHTTP(w http.ResponseWriter, r *http.Request) {
	w.Write([]byte("Hey"))
}
