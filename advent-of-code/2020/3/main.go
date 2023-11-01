package main

import (
	"bufio"
	"fmt"
	"log"
	"os"
)

func main() {
	a()
	b()
}

func a() {
	i, o := -1, 0

	scanner := bufio.NewScanner(os.Stdin)
	for scanner.Scan() {
		i++
		if i == 0 {
			continue
		}

		txt := scanner.Text()
		length := len(txt)
		pos := (i * 3) % length // this is constant but wtv

		if txt[pos] == '#' {
			o++
		}
	}

	if err := scanner.Err(); err != nil {
		log.Println(err)
	}

	fmt.Println(o)
}

func b() {
	steps := [][]int{
		{1, 1},
		{3, 1},
		{5, 1},
		{7, 1},
		{1, 2},
	}
	outputs := make([]int, len(steps))
	i := -1

	scanner := bufio.NewScanner(os.Stdin)
	for scanner.Scan() {
		i++
		if i == 0 {
			continue
		}

		txt := scanner.Text()
		length := len(txt) // this is constant but wtv

		for j, step := range steps {
			if i%step[1] != 0 {
				continue
			}

			pos := ((i / step[1]) * step[0]) % length
			if txt[pos] == '#' {
				outputs[j]++
			}
		}
	}

	if err := scanner.Err(); err != nil {
		log.Println(err)
	}

	res := 1
	for _, o := range outputs {
		res = res * o
	}
	fmt.Println(res)
}
