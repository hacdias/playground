'use strict';
var fs = require('fs');
var subtitles = require('../');

fs.readFile('test/sample.srt', 'utf8', function(err, input) {
  if (err) {
    console.log(err);
    return;
  }

  fs.readFile('test/final.srt', 'utf8', function(err, output) {
    if (err) {
      console.log(err);
      return;
    }

    input = subtitles.sync(input, [0, 4, 3, 99]);
    input = input.replace(/\s+/gm, '');
    output = output.replace(/\s+/gm, '');

    console.log(input === output)
  });
});
