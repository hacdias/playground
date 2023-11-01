package main

import (
	"bufio"
	"flag"
	"fmt"
	"net"
	"os"
	"path/filepath"
	"strconv"

	"github.com/spf13/afero"
)

var (
	port int
	dir  string
	fs   afero.Fs
)

func init() {
	flag.IntVar(&port, "port", 79, "port to run the finger daemon")
	flag.StringVar(&dir, "dir", "./", "directory with the finger files")
}

func finger(conn net.Conn) {
	defer conn.Close()
	reader := bufio.NewReader(conn)
	usr, _, _ := reader.ReadLine()

	v, err := afero.ReadFile(fs, string(usr))
	if err != nil {
		conn.Write([]byte("the user you are trying to finger cannot be found"))
	} else {
		conn.Write(v)
	}

	_ = conn.Close()
}

func fingering() int {
	ln, err := net.Listen("tcp", ":"+strconv.Itoa(port))
	if err != nil {
		fmt.Printf("failed to bind to port %d:n%s\n", port, err.Error())
		return 1
	}

	for {
		conn, err := ln.Accept()
		if err != nil {
			continue
		}

		go finger(conn)
	}
}

func main() {
	flag.Parse()

	var err error
	dir, err = filepath.Abs(dir)
	if err != nil {
		panic(err)
	}

	fs = afero.NewBasePathFs(afero.NewOsFs(), dir)
	os.Exit(fingering())
}
