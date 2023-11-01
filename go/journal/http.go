package main

import (
	"log"
	"net/http"
	"strings"
)

// Page contains the information to show on the page
type Page struct {
	Kind    string
	Index   int
	Err     error
	Length  int
	Entries []*Entry
}

// ServeHTTP is used to handle the requests.
func ServeHTTP(w http.ResponseWriter, r *http.Request) {
	// Check if it's using GET or POST.
	if r.Method != "GET" && r.Method != "POST" {
		w.WriteHeader(http.StatusMethodNotAllowed)
		return
	}

	var err error
	data := &Page{Entries: []*Entry{}}

	// If it's the new entry page.
	if strings.HasPrefix(r.URL.Path, "/new") {
		// If the method is post.
		if r.Method == "POST" {
			// Gets the form information.
			tags := r.FormValue("tags")
			text := r.FormValue("text")
			// Adds the new entry.
			err = addEntry(text, strings.Split(tags, ", "))
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

		str := strings.TrimPrefix(r.URL.Path, "/")

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
		var entry *Entry
		entry, err = getEntry(str)
		if err != nil {
			data.Kind = "error"
			data.Err = err

			// Writes the header and executes the template
			w.WriteHeader(http.StatusNotFound)
			tpl.Execute(w, data)
			return
		}

		data.Entries = append(data.Entries, entry)
		tpl.Execute(w, data)
		return
	}

	// If it's not one of the options above, we are on the
	// main page to show a listing!
	data.Entries, err = getEntries()

	if err != nil {
		data.Kind = "error"
		data.Err = err
		w.WriteHeader(http.StatusInternalServerError)
	}

	data.Kind = "listing"
	data.Length = len(data.Entries)

	tpl.Execute(w, data)
	return
}
