# interactive-command

[![Build](https://img.shields.io/travis/hacdias/interactive-command.svg?style=flat-square)][1]
[![Latest Version](https://img.shields.io/npm/v/interactive-command.svg?style=flat-square)][1]
[![Downloads per Month](https://img.shields.io/npm/dm/interactive-command.svg?style=flat-square)][1]
[![License](https://img.shields.io/npm/l/interactive-command.svg?style=flat-square)](http://opensource.org/licenses/MIT)

Run a command interactively on all operating systems, including Windows. It uses the ```child_process.spawn``` function to read the input and the output.


## Install

```sh
$ npm install --save interactive-command
```


## Usage

```js
var system = require('interactive-command.');
system(cmd, [args, cwd, callback])
```

Where:

* ```cmd``` is the command;
* ```args``` is an array of arguments for the command;
* ```options``` is the working directory where you want the execute the command;
* ```callback``` is the... callback.

Example:

```js
var system = require('interactive-command.');
system('bower', 'init');
```

It will run ```bower init``` as it runs directly from the console.

## License

MIT © [Henrique Dias](http://henriquedias.com)

[1]: https://www.npmjs.com/package/interactive-command
