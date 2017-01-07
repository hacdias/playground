package main

import (
	"bytes"
	"encoding/gob"
	"html/template"
	"strings"
	"time"

	"github.com/boltdb/bolt"
)

func init() {
	gob.Register(&Entry{})
}

// Entry contains the information of each entry.
type Entry struct {
	Title string
	Date  time.Time
	Tags  []string
	Text  string
}

func (e *Entry) encode() ([]byte, error) {
	buf := new(bytes.Buffer)
	enc := gob.NewEncoder(buf)
	err := enc.Encode(e)
	if err != nil {
		return nil, err
	}

	return buf.Bytes(), nil
}

func decode(data []byte) (*Entry, error) {
	var e *Entry
	buf := bytes.NewBuffer(data)
	dec := gob.NewDecoder(buf)
	err := dec.Decode(&e)
	if err != nil {
		return nil, err
	}
	return e, nil
}

// addEntry adds a new entry to the journal
func addEntry(text string, tags []string) error {
	// Creates a new entry with the form information
	entry := Entry{
		Date: time.Now(),
		Text: strings.TrimSpace(text),
		Tags: tags,
	}

	err := db.Update(func(tx *bolt.Tx) error {
		bucket, err := tx.CreateBucketIfNotExists([]byte("entries"))
		if err != nil {
			return err
		}

		enc, err := entry.encode()
		if err != nil {
			return err
		}

		err = bucket.Put([]byte(entry.Date.Format("200601021504")), enc)
		if err != nil {
			return err
		}
		return nil
	})

	return err
}

func getEntry(date string) (*Entry, error) {
	var e *Entry

	err := db.View(func(tx *bolt.Tx) error {
		var err error

		b := tx.Bucket([]byte("entries"))
		k := []byte(date)
		e, err = decode(b.Get(k))

		return err
	})

	return e, err
}

func getEntries() ([]*Entry, error) {
	entries := []*Entry{}

	db.View(func(tx *bolt.Tx) error {
		c := tx.Bucket([]byte("entries")).Cursor()
		for k, v := c.First(); k != nil; k, v = c.Next() {
			entry, err := decode(v)
			if err != nil {
				return err
			}

			entries = append(entries, entry)
		}
		return nil
	})

	return entries, nil
}

// TagsToString converts the tags of an entry to a string
func (e Entry) TagsToString() string {
	final := ""

	for _, v := range e.Tags {
		final += v + " "
	}

	return strings.TrimSuffix(final, " ")
}

// HTML converts the entry plain text to HTML
func (e Entry) HTML() template.HTML {
	html := e.Text
	html = "<p>" + html + "</p>"
	html = strings.Replace(html, "\n", "</p><p>", -1)
	return template.HTML(html)
}
