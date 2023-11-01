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
	a()
}

var fieldValidation = map[string]func(s string) bool{
	"byr": func(s string) bool {
		n, err := strconv.Atoi(s)
		if err != nil {
			return false
		}
		return n >= 1920 && n <= 2002
	},
	"iyr": func(s string) bool {
		n, err := strconv.Atoi(s)
		if err != nil {
			return false
		}
		return n >= 2010 && n <= 2020
	},
	"eyr": func(s string) bool {
		n, err := strconv.Atoi(s)
		if err != nil {
			return false
		}
		return n >= 2020 && n <= 2030
	},
	"hgt": func(s string) bool {
		if strings.HasSuffix(s, "cm") {
			s = strings.TrimSuffix(s, "cm")
			n, err := strconv.Atoi(s)
			if err != nil {
				return false
			}
			return n >= 150 && n <= 193
		}

		if strings.HasSuffix(s, "in") {
			s = strings.TrimSuffix(s, "in")
			n, err := strconv.Atoi(s)
			if err != nil {
				return false
			}
			return n >= 59 && n <= 76
		}
		return false
	},
	"hcl": func(s string) bool {
		if !strings.HasPrefix(s, "#") {
			return false
		}

		s = strings.TrimPrefix(s, "#")
		if len(s) != 6 {
			return false
		}

		for _, c := range s {
			if !((c >= '0' && c <= '9') || (c >= 'a' && c <= 'f')) {
				return false
			}
		}

		return true
	},
	"ecl": func(s string) bool {
		switch s {
		case "amb", "blu", "brn", "gry", "grn", "hzl", "oth":
			return true
		}
		return false
	},
	"pid": func(s string) bool {
		if len(s) != 9 {
			return false
		}

		for _, c := range s {
			if c < '0' || c > '9' {
				return false
			}
		}

		return true
	},
}

func a() {
	var requiredFields = map[string]bool{
		"byr": false,
		"iyr": false,
		"eyr": false,
		"hgt": false,
		"hcl": false,
		"ecl": false,
		"pid": false,
	}
	i := 0

	scanner := bufio.NewScanner(os.Stdin)
	for scanner.Scan() {
		txt := scanner.Text()
		txt = strings.TrimSpace(txt)

		if txt != "" {
			parts := strings.Split(txt, " ")
			for _, p := range parts {
				ps := strings.Split(p, ":")
				k := ps[0]
				if _, ok := requiredFields[k]; ok {
					requiredFields[k] = fieldValidation[k](ps[1])
					fmt.Println(k, ps[1], fieldValidation[k](ps[1]))
				}
			}
		} else {
			valid := true
			for k, v := range requiredFields {
				valid = valid && v
				requiredFields[k] = false
			}
			if valid {
				i++
			}
		}
	}

	if err := scanner.Err(); err != nil {
		log.Println(err)
	}

	fmt.Println(i)
}
