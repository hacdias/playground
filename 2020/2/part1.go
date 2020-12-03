package main

import (
	"bufio"
	"fmt"
	"log"
	"os"
	"strconv"
	"strings"
)

func isValid(s string) bool {
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

func main() {
	valid := 0

	scanner := bufio.NewScanner(os.Stdin)
	for scanner.Scan() {
		if isValid(scanner.Text()) {
			valid = valid + 1
		}
	}

	if err := scanner.Err(); err != nil {
		log.Println(err)
	}

	fmt.Println(valid)
}
