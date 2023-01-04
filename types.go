package main

type RPC struct {
	Endpoints []*Endpoint `json:"procedures"`
}

type Endpoint struct {
	Name        string      `json:"name"`
	Description string      `json:"description"`
	Arguments   []*Argument `json:"arguments"`
	Options     []*Argument `json:"options"`
	Response    []*Argument `json:"response"`
}

type Argument struct {
	Name        string `json:"name"`
	Description string `json:"description"`
	Type        string `json:"type"`
	Required    bool   `json:"required"`
	Default     string `json:"default"`
}
