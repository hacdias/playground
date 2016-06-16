# Journal

A simple command line application to keep your journal updated (it has a really nice web interface too).

## How to use it?

Firstly, you need to download it from the releases page. Then, put the binary somewhere inside your PATH environment variable. You have two choices now: run it with a web UI or only use the command line tool.

**Run web server:**

To run the web interface, you should execute ```journal --server``` on your console. By default it will be available at ```localhost:8080``` but you can change the port using the flag ```--port```.

**Use the CLI tool:**

Just run ```journal``` and then write your entry till you insert two blank newlines. Then the entry's saved. If you want to add some tags, you may use the ```--tags``` flag. E.g.: ```journal --tags "summer, awesome, hot"``` and then write the entry.
