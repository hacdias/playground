{
	"title": "Syntactic Analysis",
	"mermaid": false,
	"math": false,
	"backlinks": [
		{
			"Target": "/compiler",
			"Before": "Unknown",
			"Actual": "Syntactic Analysis",
			"After": "Unknown"
		}
	]
}

This phase is usually called **parsing**. It takes the tokens produced by the lexical analysis as input and generates a parse tree (a.k.a. syntax tree). In this phase, token arrangements are checked against the source code grammar. If the tokens are not in the correct format, errors must be thrown.

See [YACC](/yacc/)

## References

- [Introduction to Syntax](https://web.tecnico.ulisboa.pt/~david.matos/w/pt/index.php/Introduction_to_Syntax)