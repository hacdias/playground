{
	"title": "The Perfect Note-taking App",
	"mermaid": false,
	"math": false,
	"backlinks": []
}

The **must have features**:

- Notes are stored as plain files
  - Each note has an ID
  - By default the slug = the ID
  - The slug can be changed independently of the ID
  - The filename is `slug.${ext}`
  - There is an index id --> slug and slug --> id
- Back linking
  - In the end of each page, there should be links to each and every page that likes to the current page.
  - When clicking on those links, the part that refers that link should be highlighted on the target page.
  - There should be a database fast index where we can easily fetch the back links.
    - https://github.com/dgraph-io/badger
- Supports LaTeX math
- Supports Mermaid diagrams
- Clean layout
- Web editor
- Simple and humanly readble markup language
  - Markdown can be way too simple
    - https://github.com/yuin/goldmark allows for easy extensibility
  - Asciidoc has more features
  - Other?
 
The **good to have** features:

- Full-text search
  - https://github.com/blevesearch/bleve
  - https://github.com/mosuka/blast
  - https://github.com/go-ego/riot
- Mind map visualization
- WYSIWYG mode
- Login and modes:
  - All private with public pages
  - All public with private pages
- Media embedding
  - Pure HTML
  - Through the markup language
  - Upload