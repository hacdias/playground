# SubtitlesSync.js

This simple, mini-project, has as an objective creating a JavaScript script which can be added to websites to sync subtitles. The user puts how much he wants to add/remove, upload the file and it generates the new file with synchronize subtitles.

## How to use it?

If you want to use it on your project/site/platform or whatever it is, you simply have to include `SubtitlesSync.js`.

Then, you should set the input (the initial subtitles) and how much time you want to add/remove. You should do it this way:

```javascript
var sync = new SubtitlesSync();
sync.setInput(input);
sync.setChange(hours, minutes, seconds, milliseconds);
```

Finally, you just have to execute `sync.process();` and the output (final subtitles) will be available at `sync.output`.

***

Licensed under the [MIT license](http://opensource.org/licenses/MIT).
