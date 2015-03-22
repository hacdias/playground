var srtSync = {

    setInput: function (input) {
        this.input = input;
        console.log(decodeURIComponent(encodeURI(input)));
    },

    setChange: function (hours, minutes, seconds, milliseconds) {
        this.timeChange = this.timeToMilliseconds(hours, minutes, seconds, milliseconds);
        alert(this.timeChange);
        return false;
    },

    timeToMilliseconds: function(hours, minutes, seconds, milliseconds) {
        return milliseconds + seconds * 1000 + minutes * 60000 + hours * 3600000;
    },

    modifyLine: function(initialLine) {
        initialLine = initialLine.split(" --> ");
        var finalLineElements = [];

        for (var a = 0; a < initialLine.length; a++) {
            var time = this.getTime(initialLine[a]);
            time += this.timeChange;
            time = this.convertTimeToString(time);
            finalLineElements[a] = time;
        }

        return finalLineElements.join(" --> ");
    },

    getTime: function (time) {
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

        return this.timeToMilliseconds(time[0], time[1], time[2], time[3]);
    },

    convertTimeToString: function(duration) {
        var milliseconds = parseInt((duration%1000))
            , seconds = parseInt((duration/1000)%60)
            , minutes = parseInt((duration/(1000*60))%60)
            , hours = parseInt((duration/(1000*60*60))%24);

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
    },

    process: function () {
        var regex = /\d{0,2}:\d{0,2}:\d{0,2},\d{0,3} --> \d{0,2}:\d{0,2}:\d{0,2},\d{0,3}/;

        var lines = this.input.split("\n");
        this.output = "";

        for (var lineNumber = 0; lineNumber < lines.length; lineNumber++) {
            if (regex.test(lines[lineNumber])) {
                this.output += this.modifyLine(lines[lineNumber]) + "\n";
                continue;
            }
            this.output += lines[lineNumber] + "\n";
        }

        return false;
    }
};
