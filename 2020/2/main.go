package main

import (
	"bufio"
	"fmt"
	"log"
	"os"
	"strconv"
	"strings"
)

func isValidA(s string) bool {
	splt := strings.Split(s, " ")
	rg := strings.TrimSpace(splt[0])
	l := strings.TrimSpace(splt[1])
	l = strings.TrimSuffix(l, ":")
	w := strings.TrimSpace(splt[2])

	first, _ := strconv.Atoi(strings.Split(rg, "-")[0])
	last, _ := strconv.Atoi(strings.Split(rg, "-")[1])

	i := 0

	for _, k := range w {
		if k == rune(l[0]) {
			i++
		}
	}

	return i >= first && i <= last
}

func isValidB(s string) bool {
	splt := strings.Split(s, " ")
	rg := strings.TrimSpace(splt[0])
	l := strings.TrimSpace(splt[1])
	w := strings.TrimSpace(splt[2])

	first, _ := strconv.Atoi(strings.Split(rg, "-")[0])
	last, _ := strconv.Atoi(strings.Split(rg, "-")[1])

	return (w[first-1] == l[0] && w[last-1] != l[0]) || (w[first-1] != l[0] && w[last-1] == l[0])
}

func main() {
	a, b := 0

	scanner := bufio.NewScanner(os.Stdin)
	for scanner.Scan() {
		if isValidA(scanner.Text()) {
			a = a + 1
		}
		if isValidB(scanner.Text()) {
			a = b + 1
		}
	}

	if err := scanner.Err(); err != nil {
		log.Println(err)
	}

	fmt.Println(a)
	fmt.Println(b)
}
