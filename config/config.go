package config

import "log"

const (
	File    = "wpsync.json"
	Name    = "wpsync"
	Usage   = "Sync WordPress SVN with your Git or SVN repository"
	Version = "1.0.0"
)

func init() {
	log.SetFlags(0)
}
