package main

import (
	"bufio"
	"fmt"
	"log"
	"os"
	"regexp"
	"strings"
)

type BBB struct {
	contains []string
	shiny    bool
}

// NOTE: not proud!
func main() {
	rgx := regexp.MustCompile(`(.*)contain(.*)\.`)
	rgx2 := regexp.MustCompile(`\d+`)

	bags := map[string]BBB{}

	scanner := bufio.NewScanner(os.Stdin)
	for scanner.Scan() {
		txt := scanner.Text()
		txt = strings.TrimSpace(txt)

		matches := rgx.FindStringSubmatch(txt)

		bag := strings.ReplaceAll(matches[1], "bags", "")
		bag = strings.ReplaceAll(bag, "bag", "")
		bag = strings.TrimSpace(bag)

		contains := strings.Split(matches[2], ",")
		hasShiny := false
		for i, w := range contains {
			contains[i] = strings.ReplaceAll(w, "bags", "")
			contains[i] = strings.ReplaceAll(contains[i], "bag", "")
			contains[i] = rgx2.ReplaceAllString(contains[i], "")
			contains[i] = strings.TrimSpace(contains[i])
			contains[i] = strings.ReplaceAll(contains[i], "  ", " ")

			if strings.Contains(w, "shiny gold") {
				hasShiny = true
			}

			if v, ok := bags[contains[i]]; ok {
				if v.shiny {
					hasShiny = true
				}
			}
		}

		bags[bag] = BBB{
			contains: contains,
			shiny:    hasShiny,
		}
	}

	if err := scanner.Err(); err != nil {
		log.Println(err)
	}

	n := 0
	for _, bag := range bags {
		if bag.shiny {
			n++
			continue
		}

		for _, el := range bag.contains {
			if recCheck(bags, el) {
				n++
				break
			}
		}
	}

	fmt.Println(n)
}

func recCheck(bags map[string]BBB, name string) bool {
	if bag, ok := bags[name]; ok {
		if bag.shiny {
			return true
		}

		for _, el := range bag.contains {
			if recCheck(bags, el) {
				return true
			}
		}
	}

	return false
}
