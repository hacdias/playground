package main

import (
	"io/ioutil"
	"os"
	"regexp"
	"strings"
	"time"
)

const dateLayout = "2006-01-02 15:04"

// Entry contains the information of each entry.
type Entry struct {
	Date time.Time
	Tags []string
	Text string
}

// Journal contains the journal file information.
type Journal struct {
	Path      string
	Raw       []byte
	Entries   []Entry
	Retrieved time.Time
}

// Read reads the file into a string
func (j *Journal) Read() error {
	raw, err := ioutil.ReadFile(j.Path)
	if err != nil {
		return err
	}
	j.Raw = raw
	return nil
}

// ModifiedMeantime checks if the journal was modified since the last time
// it was retrieved.
func (j *Journal) ModifiedMeantime() (bool, error) {
	// Opens the file and checks if there is any error.
	file, err := os.Open(j.Path)
	if err != nil {
		if os.IsNotExist(err) {
			file, err = os.Create(j.Path)
			if err != nil {
				return false, err
			}
		} else {
			return false, err
		}
		// TODO: simplify this ^
	}

	// Gets the information of the file and checks if there is any error.
	fi, err := file.Stat()
	if err != nil {
		return false, err
	}

	// Compares both dates and returns the value.
	return fi.ModTime().After(j.Retrieved), nil
}

var dateLine = regexp.MustCompile("\\d{4}-\\d{2}-\\d{2} \\d{2}:\\d{2}")

// Parse parses the content of the file
func (j *Journal) Parse() error {
	// Checks if the file was modified meanwhile.
	mod, err := j.ModifiedMeantime()
	if err != nil {
		return err
	}

	// If it wasn't, just return nil.
	if !mod {
		return nil
	}

	// If it was, let's read the file.
	err = j.Read()
	if err != nil {
		return err
	}

	// Reset the entries parameter.
	j.Entries = []Entry{}

	date := ""
	entry := Entry{}
	lines := strings.Split(string(j.Raw), "\n")

	// Iterate each line of the file.
	for index, line := range lines {
		// If this line is the first of an entry.
		if dateLine.Match([]byte(line)) {
			// If the index is different from 1, it means, if this is not the first
			// entry of the file, then it trims the space of the text, appends the
			// entry to the journal entries array, and starts a new blank entry.
			if index != 0 {
				entry.Text = strings.TrimSpace(entry.Text)
				j.Entries = append([]Entry{entry}, j.Entries...)
				entry = Entry{}
			}

			// Gets the date parameter from the line and then parses it using
			// the default date layout.
			date = dateLine.FindString(line)
			entry.Date, err = time.Parse(dateLayout, date)
			if err != nil {
				return err
			}

			// Parses the tags from the line (the date if firstly removed from the
			// line using strings.Replace).
			entry.Tags = j.parseTags(strings.Replace(line, date, "", -1))
			continue
		}

		// Adds the current line to the text.
		entry.Text += line
	}

	// Adds the latest entry to the slice only if there any lines.
	if len(lines) > 1 {
		j.Entries = append([]Entry{entry}, j.Entries...)
	}

	// Updates the time when the entries were retrieved.
	j.Retrieved = time.Now()
	return nil
}

// AddEntry adds a new entry to the journal
func (j *Journal) AddEntry(tags, text string) error {
	// Creates a new entry with the form information
	entry := Entry{
		Date: time.Now(),
		Tags: j.parseTags(tags),
		Text: strings.TrimSpace(text),
	}

	// Builds the raw text to append to the file
	raw := entry.Date.Format(dateLayout) + " " + j.tagsToString(entry.Tags)
	raw += "\n" + entry.Text + "\n\n"

	// Appends the entry to the journal
	j.Entries = append([]Entry{entry}, j.Entries...)

	// Writes the file to append the new Entry
	file, err := os.OpenFile(j.Path, os.O_APPEND|os.O_WRONLY, 0600)
	if err != nil {
		return err
	}
	defer file.Close()

	if _, err = file.WriteString(raw); err != nil {
		return err
	}

	j.Retrieved = time.Now()
	return nil
}

// EntryIndex retrieves the index of an entry
func (j Journal) EntryIndex(date time.Time) int {
	fi := 0
	la := len(j.Entries)
	mid := 0

	for !date.Equal(j.Entries[mid].Date) {
		mid = (fi + la) / 2

		if date.After(j.Entries[mid].Date) {
			la = mid
			continue
		}

		fi = mid
		continue
	}

	return mid
}

func (j Journal) parseTags(tags string) []string {
	tags = strings.TrimSpace(tags)
	parsed := strings.Split(tags, ",")

	for i, v := range parsed {
		v = strings.TrimSpace(v)
		v = strings.TrimPrefix(v, "#")
		parsed[i] = "#" + v
	}

	return parsed
}

func (j Journal) tagsToString(tags []string) string {
	final := ""

	for _, v := range tags {
		final += v + " "
	}

	return strings.TrimSuffix(final, " ")
}
