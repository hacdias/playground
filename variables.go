package varutils

import (
	"errors"
	"log"
	"reflect"
)

var (
	errInvalidDictCall = errors.New("invalid dict call")
	errInvalidDictKey  = errors.New("dict keys must be strings")
)

// Dict allows to send more than one variable into a template.
func Dict(values ...interface{}) (map[string]interface{}, error) {
	if len(values)%2 != 0 {
		return nil, errInvalidDictCall
	}
	dict := make(map[string]interface{}, len(values)/2)
	for i := 0; i < len(values); i += 2 {
		key, ok := values[i].(string)
		if !ok {
			return nil, errInvalidDictKey
		}
		dict[key] = values[i+1]
	}

	return dict, nil
}

// FieldInStruct checks if variable is defined in a struct.
func FieldInStruct(data interface{}, field string) bool {
	t := reflect.Indirect(reflect.ValueOf(data)).Type()

	if t.Kind() != reflect.Struct {
		log.Print("Non-struct type not allowed.")
		return false
	}

	_, b := t.FieldByName(field)
	return b
}

// StringInSlice checks if a slice contains a string.
func StringInSlice(a string, list []string) (bool, int) {
	for i, b := range list {
		if b == a {
			return true, i
		}
	}
	return false, -1
}
