package main

import (
	"regexp"
)

const (
	formatExt = ".md"
)

var (
	input         string
	output        string
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
	Meta     pageMeta
	Content  []byte
	Filename string
}

type pageCollection = map[string]*pageInfo

type backlink struct {
	Target string
	Before string
	Actual string
	After  string
}
