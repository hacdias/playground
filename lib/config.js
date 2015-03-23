var config = require('../config'),
    read = require('readline'),
    error = require('../lib/error'),
    path = require('path');

var Config = function () {
    this.show = function () {
        console.log(config);
    };

    this.change = function () {
        var options = Object.keys(config);
        console.log("Choose the option you want to change:\n");

        for (var i = 0; i < options.length; i++) {
            console.log("\t" + i + " - " + options[i]);
        }

        console.log();

        var rli = read.createInterface({
            input: process.stdin,
            output: process.stdout
        });

        rli.question("Option: ", function (result) {
            rli.close();
            result = parseInt(result);

            if (result < 0 || result >= options.length || (typeof result !== 'number') || isNaN(result))
                error("Nonexistent option.");

            var rlis = read.createInterface({
                input: process.stdin,
                output: process.stdout
            });

            rlis.question("New value of \"" + options[result] + "\": ", function (answer) {
                rlis.close();

                var fs = require('fs');

                config[options[result]] = answer;
                var data = JSON.stringify(config);

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
        list: function () {
            conf.show();
        },
        change: function () {
            conf.change();
        }
    };
});