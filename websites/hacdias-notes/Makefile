.PHONY: make-dirs pinata normalize all clean build twemoji

all: clean make-dirs normalize twemoji mermaid katex

make-dirs:
	mkdir -p assets/css/vendor
	mkdir -p assets/js/vendor

normalize:
	wget https://necolas.github.io/normalize.css/8.0.1/normalize.css -O assets/css/vendor/normalize.css

mermaid:
	wget https://unpkg.com/mermaid@8.4.8/dist/mermaid.min.js -O assets/js/vendor/mermaid.min.js

twemoji:
	wget https://twemoji.maxcdn.com/v/latest/twemoji.min.js -O assets/js/vendor/twemoji.min.js

katex:
	wget https://github.com/KaTeX/KaTeX/releases/download/v0.11.1/katex.tar.gz
	tar xvf katex.tar.gz
	mv katex/katex.min.css assets/css/vendor/katex.min.css
	mv katex/katex.min.js assets/js/vendor/katex.min.js
	mv katex/contrib/auto-render.min.js assets/js/vendor/auto-render.min.js
	mv katex/contrib/mhchem.min.js assets/js/vendor/mhchem.min.js
	mkdir -p static/css/vendor
	mv katex/fonts static/css/vendor/fonts
	rm katex.tar.gz
	rm -rf katex

clean:
	rm -rf assets/css/vendor
	rm -rf assets/js/vendor
	rm -rf static/css/vendor

build:
	hugo --gc --minify --cleanDestinationDir --path-warnings

watch:
	hugo server --watch --minify --buildFuture --buildDrafts --path-warnings
