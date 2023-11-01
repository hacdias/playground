# interactive-command

[![Latest Version](https://img.shields.io/npm/v/interactive-command.svg?style=flat-square)][1]
[![Downloads per Month](https://img.shields.io/npm/dm/interactive-command.svg?style=flat-square)][1]
[![License](https://img.shields.io/npm/l/interactive-command.svg?style=flat-square)](http://opensource.org/licenses/MIT)

Run a command interactively on all operating systems, including Windows. It uses the ```child_process.spawn``` and ```child_process.spawnSync``` functions to read the input and the output.

## Install

```sh
$ npm install --save interactive-command
```

## Usage

```js
var system = require('interactive-command.');
system(cmd, [args, opts, callback])
```

Where:

* ```cmd``` is the command;
* ```args``` is an array of arguments for the command;
* ```opts``` is an object which can hold:
    + ```cwd``` is the working directory where you want the execute the command;
    + ```sync``` set true if you want it to run synchronously (default is ```false```);
    + ```suppressblank``` set false if you don't want to use the ```/s``` flag (only for Windows, default is ```true```).
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
