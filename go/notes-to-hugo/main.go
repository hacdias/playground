package main

import (
	"bytes"
	"encoding/json"
	"flag"
	"fmt"
	"io/ioutil"
	"os"
	"path/filepath"
	"strings"

	"github.com/gosimple/slug"
	"github.com/otiai10/copy"
)

func init() {
	flag.StringVar(&input, "input", "", "the input directory")
	flag.StringVar(&output, "output", "", "the output Hugo website root")
}

func main() {
	flag.Parse()

	if input == "" || output == "" {
		flag.PrintDefaults()
		os.Exit(2)
	}

	contentDir := filepath.Join(output, "content")
	attachmentsDir := filepath.Join(output, "static", "attachments")

	err := emptyDirectory(contentDir, exceptions)
	if err != nil {
		panic(err)
	}

	files, err := ioutil.ReadDir(input)
	if err != nil {
		panic(err)
	}

	err = copy.Copy(filepath.Join(input, "attachments"), attachmentsDir)
	if err != nil {
		panic(err)
	}

	list := map[string]*pageInfo{} // canonical -> data

	for _, file := range files {
		if file.IsDir() || filepath.Ext(file.Name()) != formatExt {
			fmt.Printf("ignoring %s\n", file.Name())
			continue
		}

		if err := parse(list, filepath.Join(input, file.Name()), file.Name()); err != nil {
			panic(err)
		}
	}

	for _, page := range list {
		meta, err := json.MarshalIndent(page.Meta, "", "\t")
		if err != nil {
			panic(err)
		}

		page.Content = append([]byte{'\n', '\n'}, page.Content...)
		out := filepath.Join(contentDir, page.Filename)
		ioutil.WriteFile(out, append(meta, page.Content...), 0644)
		fmt.Printf("created %s\n", out)
	}
}

func parse(col pageCollection, file, filename string) error {
	title := strings.TrimSuffix(filename, formatExt)
	canonical := slug.Make(title)

	if _, ok := col[canonical]; !ok {
		col[canonical] = &pageInfo{
			Meta: pageMeta{
				Backlinks: []backlink{},
			},
		}
	}

	content, err := ioutil.ReadFile(file)
	if err != nil {
		return err
	}

	col[canonical].Filename = canonical + formatExt
	col[canonical].Meta.Title = title
	col[canonical].Meta.Mermaid = strings.Contains(string(content), "```mermaid")
	col[canonical].Meta.Math = latexRegex.Match(content)

	col[canonical].Content = wikilinkRegex.ReplaceAllFunc(content, func(link []byte) []byte {
		original := string(link)
		original = strings.TrimPrefix(original, "[[")
		original = strings.TrimSuffix(original, "]]")

		var (
			title  string
			hash   string
			target string
		)

		if strings.Contains(original, "|") {
			parts := strings.Split(original, "|")
			if len(parts) != 2 {
				panic("invalid link, more than one #")
			}

			title = parts[1]

			if strings.HasPrefix(parts[0], "#") {
				hash = slug.Make(parts[0])
			} else if strings.Contains(parts[0], "#") {
				parts2 := strings.Split(parts[0], "#")
				if len(parts2) != 2 {
					panic("invalid link, more than one #")
				}

				target = slug.Make(parts2[0])
				hash = slug.Make(parts2[1])
			} else {
				target = slug.Make(parts[0])
			}

		} else {
			if strings.HasPrefix(original, "#") {
				title = original
				hash = slug.Make(title)
			} else if strings.Contains(original, "#") {
				parts := strings.Split(original, "#")
				if len(parts) != 2 {
					panic("invalid link, more than one #")
				}

				title = parts[0]
				target = slug.Make(parts[0])
				hash = slug.Make(parts[1])
			} else {
				title = original
				target = slug.Make(original)
			}
		}

		finalLink := "[" + title + "]("

		if target != "" {
			finalLink += "/" + target + "/"
		}

		if hash != "" {
			finalLink += "#" + hash
		}

		finalLink += ")"

		if _, ok := col[target]; !ok {
			col[target] = &pageInfo{
				Meta: pageMeta{
					Backlinks: []backlink{},
				},
			}
		}

		// Do not duplicate references. This should be removed after this package
		// _somehow_ supports references context (i.e., text before and after).
		for _, backlink := range col[target].Meta.Backlinks {
			if backlink.Target == "/"+canonical {
				return []byte(finalLink)
			}
		}

		col[target].Meta.Backlinks = append(col[target].Meta.Backlinks, backlink{
			Target: "/" + canonical,
			Before: "Unknown",
			Actual: title,
			After:  "Unknown",
		})

		return []byte(finalLink)
	})

	col[canonical].Content = bytes.ReplaceAll(
		col[canonical].Content,
		[]byte("](attachments/"),
		[]byte("](/attachments/"),
	)

	return nil
}

func emptyDirectory(dir string, exceptions []string) error {
	entries, err := ioutil.ReadDir(dir)
	if err != nil {
		return err
	}

	for _, entry := range entries {
		if contains(exceptions, entry.Name()) {
			continue
		}

		err := os.RemoveAll(filepath.Join(dir, entry.Name()))
		if err != nil {
			return err
		}
	}

	return nil
}

func contains(arr []string, str string) bool {
	for _, a := range arr {
		if a == str {
			return true
		}
	}
	return false
}
