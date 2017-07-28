package fileutils

import (
	"os"
	"testing"
)

func TestCopyFile(t *testing.T) {
	err := CopyFile("./testdata/file.txt", "./tests/file.txt")
	if err != nil {
		t.Error(err)
	}

	_, err = os.Stat("./tests/file.txt")
	if err != nil && err == os.ErrNotExist {
		t.Error(err)
	}
}

func TestCopyDir(t *testing.T) {
	err := CopyDir("./testdata/mountain", "./tests/folder/folder/folder")
	if err != nil {
		t.Error(err)
	}

	_, err = os.Stat("./tests/folder/folder/folder")
	if err != nil && err == os.ErrNotExist {
		t.Error(err)
	}

	_, err = os.Stat("./tests/folder/folder/folder/everest.txt")
	if err != nil && err == os.ErrNotExist {
		t.Error(err)
	}
}
