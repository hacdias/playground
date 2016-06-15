package main

import (
	"flag"
	"fmt"
	"html/template"
	"log"
	"net/http"
	"os"
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
	// Declare error variable and parse flags.
	var err error
	flag.Parse()

	// Check if 'serve' is being used with more flags
	// if so, close the program and show an error message
	if (serve && help) || (serve && len(tags) > 0) {
		fmt.Println("cannot use 'serve' flag with other flags")
		os.Exit(0)
	}

	// If the flag 'help' is true, show the usage for the user
	if help {
		flag.Usage()
		os.Exit(0)
	}

	// Starts up the link
	/* 	user, err := user.Current()
	if err != nil {
		panic(err)
	} */

	// TODO: check if notebook file already exists
	// The notebook file link should be at %userprofile%/.journal
	// if it doesn't, ask the user to create a new file
	// We'll do the encryption later

	jrn.Path = "D:\\journal.txt"
	jrn.Retrieved = time.Time{}
	err = jrn.Parse()

	if err != nil {
		panic(err)
	}

	// If serving is enabled, start a webserver at the defined
	// port. By default it's 8080
	if serve {
		// Build the template.
		tpl, err = template.New("template").Parse(templateString)
		if err != nil {
			panic(err)
		}

		http.HandleFunc("/", ServeHTTP)
		http.ListenAndServe(":"+strconv.Itoa(port), nil)
		return
	}
}

// Page contains the information to show on the page
type Page struct {
	Kind    string
	Journal *Journal
	Index   int
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

		var date time.Time
		str := strings.TrimPrefix(r.URL.Path, "/")
		date, err = time.Parse("200601021504", str)

		if err != nil {
			data.Kind = "error"
			tpl.Execute(w, data)
			return
		}

		data.Index = jrn.EntryIndex(date)
		tpl.Execute(w, data)
		return
	}

	err = jrn.Parse()

	if err != nil {
		log.Print(err)
		return
	}

	tpl.Execute(w, data)
	return
}
