package main

import (
	"bufio"
	"fmt"
	"log"
	"os"
	"strconv"
)

func main() {
	ns := []int{}

	scanner := bufio.NewScanner(os.Stdin)
	for scanner.Scan() {
		n, err := strconv.Atoi(scanner.Text())
		if err != nil {
			log.Fatalf(err.Error())
		}

		for i, v := range ns {
			for j, k := range ns {
				if i == j {
					continue
				}

				if v+k+n == 2020 {
					fmt.Println(v * k * n)
					return
				}
			}

		}

		ns = append(ns, n)
	}

	if err := scanner.Err(); err != nil {
		log.Println(err)
	}
}
