package fileutils

import "testing"

func TestDir(t *testing.T) {
	testdata := Dir("./testdata")

	err := testdata.Copy("/mountain", "/test")
	if err != nil {
		t.Error(err)
	}

	err = testdata.Rename("/test/everest.txt", "/test/everest2.txt")
	if err != nil {
		t.Error(err)
	}

	_, err = testdata.Stat("/test/everest2.txt")
	if err != nil {
		t.Error(err)
	}

	err = testdata.Mkdir("/test/qwe/rty/uio/pas/dfg/gh", 0666)
	if err != nil {
		t.Error(err)
	}

	err = testdata.RemoveAll("/test")
	if err != nil {
		t.Error(err)
	}
}
