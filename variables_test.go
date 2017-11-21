package varutils

import "testing"

type testFieldInStructData struct {
	f1 string
	f2 bool
	f3 int
	f4 func()
}

type testFieldInStruct struct {
	data   interface{}
	field  string
	result bool
}

var testFieldInStructCases = []testFieldInStruct{
	{testFieldInStructData{}, "f1", true},
	{testFieldInStructData{}, "f2", true},
	{testFieldInStructData{}, "f3", true},
	{testFieldInStructData{}, "f4", true},
	{testFieldInStructData{}, "f5", false},
	{testFieldInStructData{}, "f6", false},
	{[]string{}, "", false},
	{map[string]int{"oi": 4}, "", false},
	{"asa", "", false},
	{"int", "", false},
}

func TestFieldInStruct(t *testing.T) {
	for _, pair := range testFieldInStructCases {
		v := FieldInStruct(pair.data, pair.field)
		if v != pair.result {
			t.Error(
				"For", pair.data,
				"expected", pair.result,
				"got", v,
			)
		}
	}
}

var testStringInSliceCases = []struct {
	Slice  []string
	Search string
	Index  int
	Result bool
}{
	{[]string{"f1", "f2", "f3"}, "f1", 0, true},
	{[]string{"f1", "f2", "f3"}, "f2", 1, true},
	{[]string{"f1", "f2", "f3"}, "f3", 2, true},
	{[]string{"f1", "f2", "f3"}, "f4", -1, false},
}

func TestStringInSlice(t *testing.T) {
	for _, c := range testStringInSliceCases {
		res, i := StringInSlice(c.Search, c.Slice)
		if res != c.Result || i != c.Index {
			t.Error(
				"For", c.Slice, c.Search,
				"expected", c.Result, c.Index,
				"got", res, i,
			)
		}
	}
}
