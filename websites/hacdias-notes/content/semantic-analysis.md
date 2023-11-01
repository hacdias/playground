{
	"title": "Semantic Analysis",
	"mermaid": false,
	"math": false,
	"backlinks": [
		{
			"Target": "/compiler",
			"Before": "Unknown",
			"Actual": "Semantic Analysis",
			"After": "Unknown"
		}
	]
}

After generating the parse tree, it is important to check if every element of the tree follows the rules. For example, check if you assign the right type of literal to the right type of variable. In addition, this phase tracks identifiers, types and expressions; it knows whether identifiers are declared before used or not. The output is called an annotated syntax tree.