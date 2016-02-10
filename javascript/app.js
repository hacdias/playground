'use strict';

document.addEventListener('DOMContentLoaded', function() {
  var file = document.getElementById('file');
  var form = document.getElementById('form');

  form.onsubmit = function(event) {
    event.preventDefault();
    file.click();
    return false;
  }

  // When the form is submited
  file.onchange = function(event) {
    event.preventDefault();

    function NaNToZero(time) {
      return isNaN(time) ? 0 : time;
    }

    var hours = parseInt(document.getElementById('h').value);
    var minutes = parseInt(document.getElementById('m').value);
    var seconds = parseInt(document.getElementById('s').value);
    var milliseconds = parseInt(document.getElementById('ms').value);

    hours = NaNToZero(hours);
    minutes = NaNToZero(minutes);
    seconds = NaNToZero(seconds);
    milliseconds = NaNToZero(milliseconds);

    var files = file.files;

    if (files.length > 1) {
      alert('Something is wrong.');
      return false;
    }

    var name = files[0].name;

    var reader = new FileReader();
    reader.onload = function(event) {
      var input = event.target.result;
      var nContent = sync(input, [hours, minutes, seconds, milliseconds]);
      var element = document.createElement('a');
      element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(nContent));
      element.setAttribute('download', name);

      element.style.display = 'none';
      document.body.appendChild(element);

      element.click();

      document.body.removeChild(element);
    };

    reader.readAsText(files[0]);
    return false;
  }

}, false);


var sync = (function(input, time) {
  const regex = /\d{0,2}:\d{0,2}:\d{0,2},\d{0,3} --> \d{0,2}:\d{0,2}:\d{0,2},\d{0,3}/;

  var timeChange = parseInt(getMilliseconds.apply(this, time)),
    lines = input.split("\n"),
    output = "";

  function getMilliseconds(hours, minutes, seconds, milliseconds) {
    return milliseconds + seconds * 1000 + minutes * 60000 + hours * 3600000;
  }

  function modifyLine(initialLine) {
    initialLine = initialLine.split(" --> ");
    var finalLineElements = [];

    for (var a = 0; a < initialLine.length; a++) {
      var time = getTime(initialLine[a]);
      time += timeChange;
      finalLineElements[a] = timeToString(time);
    }

    return finalLineElements.join(" --> ");
  }

  function getTime(time) {
    time = time.split(":");

    if (time.length > 3)
      return false;

    var temporary = time[2].split(",");

    time.pop();

    for (var i = 0; i < temporary.length; i++)
      time[time.length] = temporary[i];

    for (var j = 0; j < time.length; j++)
      time[j] = parseInt(time[j]);

    if (time.length < 4)
      return false;

    return getMilliseconds(time[0], time[1], time[2], time[3]);
  }

  function timeToString(time) {
    var milliseconds = time % 1000;
    time = (time - milliseconds) / 1000;
    var seconds = time % 60;
    time = (time - seconds) / 60;
    var minutes = time % 60;
    var hours = (time - minutes) / 60;

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
  }

  for (var i = 0; i < lines.length; i++) {
    if (regex.test(lines[i])) {
      output += modifyLine(lines[i]) + "\n";
      continue;
    }
    output += lines[i] + "\n";
  }

  return output;
});
