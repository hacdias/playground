package main

type RPC struct {
	Endpoints []*Endpoint `json:"procedures"`
}

type Endpoint struct {
	Name        string      `json:"name"`
	Description string      `json:"description"`
	Arguments   []*Argument `json:"arguments"`
	Options     []*Option   `json:"options"`
	Response    []*Argument `json:"response"`
}

type Option struct {
	Name        string `json:"name"`
	Description string `json:"description"`
	Type        string `json:"type"`
	Default     string `json:"default"`
}

type Argument struct {
	Name        string `json:"name"`
	Description string `json:"description"`
	Type        string `json:"type"`
	Default     string `json:"default"`
	Required    bool   `json:"required"`
	Variadic    bool   `json:"variadic"`
}
