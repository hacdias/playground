package main

import (
	"bufio"
	"fmt"
	"log"
	"os"
	"sort"
	"strings"
)

func main() {
	arr := []int{}

	scanner := bufio.NewScanner(os.Stdin)
	for scanner.Scan() {
		txt := scanner.Text()
		txt = strings.TrimSpace(txt)
		arr = append(arr, computeSeat(txt))
	}

	if err := scanner.Err(); err != nil {
		log.Println(err)
	}

	sort.Ints(arr)

	for i := range arr {
		if i == 0 {
			continue
		}

		if arr[i]-arr[i-1] == 2 {
			fmt.Println(arr[i] - 1)
		}
	}
}

func computeSeat(s string) int {
	row_low, row_high := 0, 127
	column_low, column_high := 0, 7

	for _, c := range s {
		switch c {
		case 'F':
			row_high = (row_high-row_low)/2 + row_low
		case 'B':
			row_low = (row_high + row_low) / 2
		case 'R':
			column_low = (column_high + column_low) / 2
		case 'L':
			column_high = (column_high-column_low)/2 + column_low
		default:
			panic("invalid letter")
		}
	}

	return (row_low+1)*8 + column_high
}
