package main

import (
	"bufio"
	"fmt"
	"log"
	"os"
	"strings"
)

func main() {
	// anyone()
	everyone()
}

func anyone() {
	is := map[rune]bool{}
	n := 0

	scanner := bufio.NewScanner(os.Stdin)
	for scanner.Scan() {
		txt := scanner.Text()
		txt = strings.TrimSpace(txt)

		if txt == "" {
			for range is {
				n++
			}

			is = map[rune]bool{}
		} else {
			for _, c := range txt {
				is[c] = true
			}
		}
	}

	if err := scanner.Err(); err != nil {
		log.Println(err)
	}

	fmt.Println(n)
}

func everyone() {
	is := map[rune]int{}
	n, k := 0, 0

	scanner := bufio.NewScanner(os.Stdin)
	for scanner.Scan() {
		txt := scanner.Text()
		txt = strings.TrimSpace(txt)

		if txt == "" {
			for _, j := range is {
				if j == k {
					n++
				}
			}

			is = map[rune]int{}
			k = 0
		} else {
			k++
			for _, c := range txt {
				if _, ok := is[c]; !ok {
					is[c] = 1
				} else {
					is[c]++
				}
			}
		}
	}

	if err := scanner.Err(); err != nil {
		log.Println(err)
	}

	fmt.Println(n)
}
