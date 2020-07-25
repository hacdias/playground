package main

import "regexp"

const (
	input     = "/Users/henriquedias/Documents/Notes"
	output    = "/Users/henriquedias/Code/hacdias/notes.hacdias.com/content"
	formatExt = ".md"
)

var (
	latexRegex    = regexp.MustCompile(`(\$\$.*?\$\$|\$.*?\$)`)
	wikilinkRegex = regexp.MustCompile(`\[\[(.*?)\]\]`)
	exceptions    = []string{
		"_index.md",
	}
)

type pageMeta struct {
	Title     string     `json:"title"`
	Mermaid   bool       `json:"mermaid"`
	Math      bool       `json:"math"`
	Backlinks []backlink `json:"backlinks"`
}

type pageInfo struct {
	Meta    pageMeta
	Content []byte
	Out     string
}

type pageCollection = map[string]*pageInfo

type backlink struct {
	Target string
	Before string
	Actual string
	After  string
}
