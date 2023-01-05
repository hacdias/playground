package main

import "reflect"

type RPC struct {
	Endpoints []*Endpoint `json:"procedures"`
}

type Endpoint struct {
	Name        string      `json:"name"`
	Description string      `json:"description"`
	Arguments   []*Argument `json:"arguments"`
	Options     []*Option   `json:"options"`
	Response    *Response   `json:"response"`
}

type Option struct {
	Name        string      `json:"name"`
	Description string      `json:"description"`
	Type        string      `json:"type"`
	Default     interface{} `json:"default"`
}

type Argument struct {
	Name        string `json:"name"`
	Description string `json:"description"`
	Type        string `json:"type"`
	Required    bool   `json:"required"`
	Variadic    bool   `json:"variadic"`
}

type Response struct {
	Name   string
	Type   reflect.Kind
	Fields []*Response
}
