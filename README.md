# subtitles-sync

[![Build](https://img.shields.io/travis/hacdias/subtitles-sync.svg?style=flat-square)][1]
[![Latest Version](https://img.shields.io/npm/v/subtitles-sync.svg?style=flat-square)][1]
[![Downloads per Month](https://img.shields.io/npm/dm/subtitles-sync.svg?style=flat-square)][1]
[![License](https://img.shields.io/npm/l/subtitles-sync.svg?style=flat-square)](http://opensource.org/licenses/MIT)

This package can be used to synchronize .srt subtitles. It is very simple to use and allows you to advance or delay your subtitles.

## Install

```
$ npm install --save subtitles-sync
```

## Usage

```js
var subtitles = require('subtitles-sync');

subtitles.sync(input, [hours, minutes, seconds, milliseconds]);
// => A string with the new subtitles

```


## License

MIT © [Henrique Dias](http://henriquedias.com)

[1]: https://www.npmjs.com/package/subtitles-sync
