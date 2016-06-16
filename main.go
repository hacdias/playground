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
	"time"
)

var (
	tags  string
	serve bool
	port  int
	help  bool
	jrn   *Journal
	tpl   *template.Template
)

func init() {
	jrn = new(Journal)

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
		jrnlPath := filepath.Join(user.HomeDir, "journal.txt")
		fmt.Print("Journal file (leave blank for " + jrnlPath + "): ")

		var text string
		reader := bufio.NewReader(os.Stdin)
		text, err = reader.ReadString('\n')
		text = strings.TrimSpace(text)

		if err != nil {
			panic(err)
		}

		if text == "" {
			jrn.Path = jrnlPath
		} else {
			jrn.Path = text
		}

		_, err = os.Create(jrn.Path)
		if err != nil {
			log.Panic(err)
		}

		err = ioutil.WriteFile(confPath, []byte(jrn.Path), 0600)
		if err != nil {
			panic(err)
		}
	} else {
		var raw []byte
		raw, err = ioutil.ReadFile(confPath)

		if err != nil {
			panic(err)
		}

		jrn.Path = strings.TrimSpace(string(raw))
	}

	jrn.Retrieved = time.Time{}

	// If serving is enabled, start a webserver at the defined
	// port. By default it's 8080
	if serve {
		err = jrn.Parse()
		if err != nil {
			panic(err)
		}

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
		fmt.Println("Hey")
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

	err = jrn.AddEntry(tags, text)

	if err != nil {
		panic(err)
	}

	fmt.Println("Entry added!")
}

// Page contains the information to show on the page
type Page struct {
	Kind    string
	Journal *Journal
	Index   int
	Err     error
	Length  int
}

// ServeHTTP is used to handle the requests.
func ServeHTTP(w http.ResponseWriter, r *http.Request) {
	// Check if it's using GET or POST.
	if r.Method != "GET" && r.Method != "POST" {
		w.WriteHeader(http.StatusNotImplemented)
		return
	}

	var err error
	data := &Page{Journal: jrn}

	// If it's the new entry page.
	if strings.HasPrefix(r.URL.Path, "/new") {
		// If the method is post.
		if r.Method == "POST" {
			// Gets the form information.
			tags := r.FormValue("tags")
			text := r.FormValue("text")
			// Adds the new entry.
			err = jrn.AddEntry(tags, text)
			if err != nil {
				log.Println(err)
			}
			// Redirects the user to the front-page.
			http.Redirect(w, r, "/", http.StatusTemporaryRedirect)
			return
		}

		// If it's another method.
		data.Kind = "new"
		tpl.Execute(w, data)
		return
	}

	// If it's a single page
	if r.URL.Path != "/" {
		data.Kind = "single"

		// Parses the date
		var date time.Time
		str := strings.TrimPrefix(r.URL.Path, "/")
		date, err = time.Parse("200601021504", str)

		// If it can't parse the date, it's because the user
		// is in an invalid URL
		if err != nil {
			data.Kind = "error"
			data.Err = err

			// Writes the header and executes the template
			w.WriteHeader(http.StatusNotFound)
			tpl.Execute(w, data)
			return
		}

		// Gets the index of the current entry and executes the template
		data.Index = jrn.EntryIndex(date)
		tpl.Execute(w, data)
		return
	}

	// If it's not one of the options above, we are on the
	// main page to show a listing!
	err = jrn.Parse()

	data.Kind = "listing"
	data.Length = len(data.Journal.Entries)

	if err != nil {
		data.Kind = "error"
		data.Err = err
		w.WriteHeader(http.StatusInternalServerError)
	}

	tpl.Execute(w, data)
	return
}
