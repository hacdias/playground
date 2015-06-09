/**
 * subtitles-sync package
 * @author: Henrique Dias <hacdias@gmail.com> (http://henriquedias.com)
 */
'use strict';

var moment = require('moment');

module.exports = {
  sync: function(input, time) {
    var sync = new SubtitlesSync();
    sync.setInput(input);
    sync.setChange.apply(this, time);
    sync.process();
    return sync.output;
  }
}

var SubtitlesSync = function () {
    var self = this;

    this.setInput = function (input) {
        self.input = input;
    };

    this.setChange = function (hours, minutes, seconds, milliseconds) {
        self.timeChange = self.timeToMilliseconds(hours, minutes, seconds, milliseconds);
        return false;
    };

    this.timeToMilliseconds = function (hours, minutes, seconds, milliseconds) {
        return milliseconds + seconds * 1000 + minutes * 60000 + hours * 3600000;
    };

    this.modifyLine = function (initialLine) {
        initialLine = initialLine.split(" --> ");
        var finalLineElements = [];

        for (var a = 0; a < initialLine.length; a++) {
            var time = self.getTime(initialLine[a]);
            time += self.timeChange;
            time = self.convertTimeToString(time);
            finalLineElements[a] = time;
        }

        return finalLineElements.join(" --> ");
    };

    this.getTime = function (time) {
        time = time.split(":");

        if (time.length > 3)
            return false;

        var temporary = time[2].split(",");

        time.pop();

        for (var i = 0; i < temporary.length; i++) {
            time[time.length] = temporary[i];
        }

        for (var j = 0; j < time.length; j++) {
            time[j] = parseInt(time[j]);
        }

        if (time.length < 4)
            return false;

        return self.timeToMilliseconds(time[0], time[1], time[2], time[3]);
    };

    this.convertTimeToString = function (duration) {
        var milliseconds = parseInt((duration % 1000)),
            seconds = parseInt((duration / 1000) % 60),
            minutes = parseInt((duration / (60000)) % 60),
            hours = parseInt((duration / (3600000)) % 24);

        hours = (hours < 10) ? "0" + hours : hours;
        minutes = (minutes < 10) ? "0" + minutes : minutes;
        seconds = (seconds < 10) ? "0" + seconds : seconds;

        if (milliseconds < 100) {
            if (milliseconds < 10) {
                milliseconds = "00" + milliseconds;
            } else {
                milliseconds = "0" + milliseconds;
            }
        }

        return hours + ":" + minutes + ":" + seconds + "," + milliseconds;
    };

    this.process = function (callback) {
        var regex = /\d{0,2}:\d{0,2}:\d{0,2},\d{0,3} --> \d{0,2}:\d{0,2}:\d{0,2},\d{0,3}/;

        var lines = self.input.split("\n");
        self.output = "";

        for (var lineNumber = 0; lineNumber < lines.length; lineNumber++) {
            if (regex.test(lines[lineNumber])) {
                self.output += self.modifyLine(lines[lineNumber]) + "\n";
                continue;
            }
            self.output += lines[lineNumber] + "\n";
        }

        if (typeof callback === 'function') callback();
        return false;
    };
};
