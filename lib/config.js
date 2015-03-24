var config = require('../config'),
    read = require('readline'),
    error = require('../lib/error'),
    path = require('path');

var Config = function () {
    var options = Object.keys(config);

    this.show = function () {
        console.log("\nYour Sitify configuration: \n");

        for (var i = 0; i < options.length; i++) {
            console.log("\t" + options[i] + " - " + config[options[i]]);
        }
    };

    this.change = function () {
        console.log("Choose the option you want to change:\n");

        for (var i = 0; i < options.length; i++) {
            console.log("\t" + i + " - " + options[i]);
        }
        console.log();

        var readInterface = read.createInterface({
            input: process.stdin,
            output: process.stdout
        });

        readInterface.question("Option: ", function (result) {
            readInterface.close();
            result = parseInt(result);

            if (result < 0 || result >= options.length || (typeof result !== 'number') || isNaN(result))
                error("Nonexistent option.");

            var newReadInterface = read.createInterface({
                input: process.stdin,
                output: process.stdout
            });

            newReadInterface.question("New value of \"" + options[result] + "\": ", function (answer) {
                newReadInterface.close();
                config[options[result]] = answer;

                var data = JSON.stringify(config);
                var fs = require('fs');

                fs.writeFile(path.normalize(path.dirname(__dirname) + '/config.json'), data, function (err) {
                    if (err) {
                        error("There has been an error saving your configuration data. + \n" + err.message);
                    }
                    console.log('Configuration saved successfully.')
                });
            });
        });
    };
};

module.exports = (function () {
    var conf = new Config();

    return {
        change: function () {
            conf.change();
        },
        show: function () {
            conf.show();
        }
    };
});