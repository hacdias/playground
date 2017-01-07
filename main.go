package main

import (
	"bufio"
	"flag"
	"fmt"
	"html/template"
	"io/ioutil"
	"log"
	"net/http"
	"os"
	"os/user"
	"path/filepath"
	"strconv"
	"strings"

	"github.com/boltdb/bolt"
)

var (
	tags  string
	serve bool
	port  int
	help  bool
	//	jrn   *Journal
	tpl *template.Template

	path string

	db *bolt.DB
)

func init() {
	//jrn = new(Journal)

	flag.Usage = func() {
		fmt.Println("Journal usage:")
		fmt.Println("")
		flag.PrintDefaults()
		fmt.Println("")
		fmt.Println("Brought to you by Henrique Dias (@hacdias).")
	}

	flag.StringVar(&tags, "tags", "", "set the tags for this entry separated by spaces")
	flag.BoolVar(&serve, "serve", false, "run the journal as a webserver")
	flag.BoolVar(&help, "help", false, "this screen")
	flag.IntVar(&port, "port", 8080, "webserver port for journal")
}

func main() {
	// Declare error variable and parse flags.
	var err error
	flag.Parse()

	// Check if 'serve' is being used with more flags
	// if so, close the program and show an error message
	if (serve && help) || (serve && len(tags) > 0) {
		fmt.Println("cannot use 'serve' flag with other flags\nrun 'journal --help' to know more")
		os.Exit(0)
	}

	// If the flag 'help' is true, show the usage for the user
	if help {
		flag.Usage()
		os.Exit(0)
	}

	// Starts up the link
	user, err := user.Current()
	if err != nil {
		panic(err)
	}

	confPath := filepath.Join(user.HomeDir, ".journal")

	// Checks if the file %userprofile%/.journal exists
	if _, err = os.Stat(confPath); os.IsNotExist(err) {
		path = filepath.Join(user.HomeDir, "journal.db")
		fmt.Print("Journal file (leave blank for " + path + "): ")

		var text string
		reader := bufio.NewReader(os.Stdin)
		text, err = reader.ReadString('\n')
		text = strings.TrimSpace(text)

		if err != nil {
			log.Fatal(err)
		}

		if text != "" {
			path = text
		}

		err = ioutil.WriteFile(confPath, []byte(path), 0600)
		if err != nil {
			log.Fatal(err)
		}
	} else {
		var raw []byte
		raw, err = ioutil.ReadFile(confPath)

		if err != nil {
			panic(err)
		}

		path = strings.TrimSpace(string(raw))
	}

	db, err = bolt.Open(path, 0600, nil)
	if err != nil {
		log.Fatal(err)
	}

	defer db.Close()

	err = db.Update(func(tx *bolt.Tx) error {
		_, err = tx.CreateBucketIfNotExists([]byte("entries"))
		return err
	})

	// If serving is enabled, start a webserver at the defined
	// port. By default it's 8080
	if serve {
		// Build the template.
		tpl, err = template.New("template").Parse(templateString)
		if err != nil {
			panic(err)
		}

		fmt.Println("Serving at localhost:" + strconv.Itoa(port))
		http.HandleFunc("/", ServeHTTP)
		http.ListenAndServe(":"+strconv.Itoa(port), nil)
		return
	}

	// New command line entry
	var text string

	for _, val := range flag.Args() {
		text += val
	}

	if len(flag.Args()) == 0 {
		reader := bufio.NewReader(os.Stdin)
		var line string

		for !strings.HasSuffix(text, "\n\n") {
			line, err = reader.ReadString('\n')

			if err != nil {
				panic(err)
			}

			text += strings.TrimSpace(line) + "\n"
		}
	}

	err = addEntry(text, strings.Split(tags, " "))
	if err != nil {
		panic(err)
	}

	fmt.Println("Entry added!")
}
