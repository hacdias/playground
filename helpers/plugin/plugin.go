package plugin

import (
	"fmt"
	"io/ioutil"
	"log"
	"os"
	"path/filepath"
	"regexp"
	"strconv"
	"strings"

	"github.com/hacdias/wp-sync/helpers/command"
	"github.com/hacdias/wp-sync/helpers/versioncontrol"
	"github.com/termie/go-shutil"
)

const (
	pluginFileRegex = "Version:[ \\t]*[\\d+\\.]+\\d"
	readmeFileRegex = "Stable tag:[ \\t]*[\\d+\\.]+\\d"
)

// Plugin is
type Plugin struct {
	PluginFile, ReadmeFile, Index            string
	pluginFileContent, readmeFileContent     string
	oldVersion, newVersion                   []int
	FilesIgnore                              []string
	index                                    int
	theVersion, versionControl, WordpressSvn string
}

// Update is
func (p Plugin) Update() {
	p.getPluginFileContent()
	p.getReadmeFileContent()
	p.getCurrentVersion()
	p.getNewVersion()

	fmt.Println("Confirm you want to update your plugin to v" + p.theVersion + " (y/n)")

	if !command.AskForConfirmation() {
		os.Exit(0)
	}

	p.changeVersionFiles()
	p.updateMainRepo()
	p.updateWordPressRepo()
}

func (p *Plugin) getPluginFileContent() {
	file, err := ioutil.ReadFile(p.PluginFile)

	if err != nil {
		log.Fatal(err)
	}

	p.pluginFileContent = string(file)
}

func (p *Plugin) getReadmeFileContent() {
	file, err := ioutil.ReadFile(p.ReadmeFile)

	if err != nil {
		log.Fatal(err)
	}

	p.readmeFileContent = string(file)
}

func (p *Plugin) getCurrentVersion() {
	re := regexp.MustCompile(pluginFileRegex)
	match := re.FindString(p.pluginFileContent)

	if match == "" {
		log.Fatal("unknown version in " + p.PluginFile + " file")
	}

	re = regexp.MustCompile("[\\d+\\.]+\\d")
	match = re.FindString(match)
	versionStringMap := strings.Split(match, ".")

	versionArray := []int{0, 0, 0, 0}

	for index, num := range versionStringMap {
		aa, err := strconv.Atoi(num)

		if err != nil {
			log.Fatal(err)
		}

		versionArray[index] = aa
	}

	p.oldVersion = versionArray
}

func (p *Plugin) getNewVersion() {
	// get the version index to update
	// major.minor[.build[.revision]]
	// default is build
	indexList := map[string]int{}
	indexList["major"] = 0
	indexList["minor"] = 1
	indexList["build"] = 2
	indexList["revision"] = 3

	p.index = indexList[p.Index]
	p.newVersion = p.oldVersion
	p.getNewVersionRecursively()

	for _, value := range p.newVersion {
		p.theVersion += "." + strconv.Itoa(value)
	}

	p.theVersion = p.theVersion[1:len(p.theVersion)]
}

func (p *Plugin) getNewVersionRecursively() {
	if p.newVersion[p.index]+1 > 9 && p.index != 0 {
		p.newVersion[p.index] = 0
		p.index--
		p.getNewVersionRecursively()
	} else {
		p.newVersion[p.index]++
	}
}

func (p *Plugin) changeVersionFiles() {
	pluginReplaceText := "Version: " + p.theVersion
	re := regexp.MustCompile(pluginFileRegex)
	p.pluginFileContent = re.ReplaceAllLiteralString(p.pluginFileContent, pluginReplaceText)

	err := ioutil.WriteFile(p.PluginFile, []byte(p.pluginFileContent), 0777)

	if err != nil {
		log.Fatal(err)
	}

	readmeReplaceText := "Stable tag: " + p.theVersion
	re = regexp.MustCompile(readmeFileRegex)
	p.readmeFileContent = re.ReplaceAllLiteralString(p.readmeFileContent, readmeReplaceText)

	err = ioutil.WriteFile(p.ReadmeFile, []byte(p.readmeFileContent), 0777)

	if err != nil {
		log.Fatal(err)
	}
}

func (p *Plugin) checkMainRepoType() {
	if _, err := os.Stat(".svn"); err == nil {
		p.versionControl = "svn"
	} else {
		p.versionControl = "git"
	}
}

func (p *Plugin) updateMainRepo() {
	p.checkMainRepoType()

	if p.versionControl == "svn" {
		svn := versioncontrol.Svn{}
		svn.Tag = "v" + p.theVersion
		svn.Commit = "v" + p.theVersion
		svn.Update()
		return
	}

	git := versioncontrol.Git{}
	git.Tag = "v" + p.theVersion
	git.Commit = "v" + p.theVersion
	git.Update()
}

func (p Plugin) updateWordPressRepo() {
	// save the path where we're working and creates a temporary one
	mainPath, _ := os.Getwd()
	tempPath, _ := ioutil.TempDir(os.TempDir(), "wpsync")

	// changes the working directory to the temporary path
	os.Chdir(tempPath)

	command.Run("svn", "checkout", p.WordpressSvn, ".")

	trunk := filepath.Join(tempPath, "trunk")

	// clean trunk folder
	os.RemoveAll(trunk)

	// set the files to ignore
	options := shutil.CopyTreeOptions{}
	//options.Ignore = func ("", p.FilesIgnore)

	// copy the new plugin files to the temporary_folder, ignoring some files
	shutil.CopyTree(mainPath, trunk, &options)

	// update the repository
	svn := versioncontrol.Svn{}
	svn.Commit = "v" + p.theVersion
	svn.Tag = "v" + p.theVersion
	svn.Update()

	// remove temporary folder and return to the main working directory
	os.RemoveAll(tempPath)
	os.Chdir(mainPath)
}
