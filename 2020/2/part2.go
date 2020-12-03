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
	w := strings.TrimSpace(splt[2])

	first, _ := strconv.Atoi(strings.Split(rg, "-")[0])
	last, _ := strconv.Atoi(strings.Split(rg, "-")[1])

	return (w[first-1] == l[0] && w[last-1] != l[0]) || (w[first-1] != l[0] && w[last-1] == l[0])
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
