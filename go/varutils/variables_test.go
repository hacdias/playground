package varutils

import (
	"reflect"
	"testing"
)

var testDictCases = []struct {
	argument []interface{}
	result   map[string]interface{}
	err      error
}{
	{
		[]interface{}{"k1", "v1", "k2", "v2", "k3", "v3"},
		map[string]interface{}{
			"k1": "v1",
			"k2": "v2",
			"k3": "v3",
		},
		nil,
	},
	{
		[]interface{}{"k1", "v1", "k2", "v2", "k3"},
		nil,
		errInvalidDictCall,
	},
	{
		[]interface{}{2, "v1", "k2", "v2", "k3", "v3"},
		nil,
		errInvalidDictKey,
	},
}

func TestDict(t *testing.T) {
	for _, test := range testDictCases {
		res, err := Dict(test.argument...)

		if !reflect.DeepEqual(res, test.result) {
			t.Error(
				"For", test.argument,
				"expected", test.result,
				"got", res,
			)
		}

		if err != test.err {
			t.Error(
				"For", test.argument,
				"expected", test.err,
				"got", err,
			)
		}
	}
}

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
