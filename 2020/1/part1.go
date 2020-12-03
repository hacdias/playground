package main

import (
	"bufio"
	"fmt"
	"log"
	"os"
	"strconv"
)

func main() {
	numbers := []int{}

	scanner := bufio.NewScanner(os.Stdin)
	for scanner.Scan() {
		i, err := strconv.Atoi(scanner.Text())
		if err != nil {
			log.Fatalf(err.Error())
		}

		for _, v := range numbers {
			if i+v == 2020 {
				fmt.Println(i * v)
				return
			}
		}

		numbers = append(numbers, i)
	}

	if err := scanner.Err(); err != nil {
		log.Println(err)
	}
}
