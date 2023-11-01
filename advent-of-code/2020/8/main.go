package main

import (
	"bufio"
	"fmt"
	"log"
	"os"
	"strconv"
	"strings"
)

func main() {
	insts := []string{}
	scanner := bufio.NewScanner(os.Stdin)

	for scanner.Scan() {
		txt := scanner.Text()
		txt = strings.TrimSpace(txt)
		insts = append(insts, txt)
	}

	if err := scanner.Err(); err != nil {
		log.Println(err)
	}

	// Part I
	acc, _ := run(insts)
	fmt.Println(acc)

	// Part II: not pround for brute force. Backtracking would have
	// been nice but this was faster to code.
	for i, inst := range insts {
		var (
			acc  int
			ok   bool
			prev = inst
		)

		switch {
		case strings.HasPrefix(inst, "jmp"):
			inst = strings.Replace(inst, "jmp", "nop", -1)
			insts[i] = inst
			acc, ok = run(insts)
		case strings.HasPrefix(inst, "nop"):
			inst = strings.Replace(inst, "nop", "jmp", -1)
			insts[i] = inst
			acc, ok = run(insts)
		}

		if !ok {
			insts[i] = prev
		} else {
			fmt.Println(acc)
			break
		}
	}
}

func run(insts []string) (acc int, ok bool) {
	visited := map[int]bool{}
	i := 0
	for {
		if visited[i] {
			return
		}
		if i == len(insts) {
			break
		}

		visited[i] = true
		inst := insts[i]
		parts := strings.Split(inst, " ")

		n, err := strconv.Atoi(parts[1])
		if err != nil {
			panic(err)
		}

		switch parts[0] {
		case "acc":
			acc = acc + n
			i++
		case "jmp":
			i = i + n
		case "nop":
			i++
		}
	}

	ok = true
	return
}
