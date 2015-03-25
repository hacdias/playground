var config = require('../config'),
    read = require('readline'),
    error = require('./helpers/error'),
    path = require('path'),
    welcome = require('./helpers/welcome'),
    chalk = require('chalk');

var Config = function () {
    var self = this;

    this.options = Object.keys(config);
    this.title = "CONFIGURATION";
    this.description = "If you want to see or change the configuration of sitify, you're in the right place. Use " +
    "'-c' to change the configuration.";

    welcome(this.title, this.description);

    this.show = function () {
        console.log(chalk.bgCyan('Current configuration') + "\n");

        for (var i = 0; i < self.options.length; i++) {
            console.log(self.options[i] + ":\t\t" + config[self.options[i]]);
        }
    };

    this.loopConfigItems = function (callback) {
        if (typeof self.newConfig === 'undefined')
            self.newConfig = {};

        if (typeof that === 'undefined')
            var that = this;

        if (typeof that.rl === 'undefined') {
            that.rl = read.createInterface({
                input: process.stdin,
                output: process.stdout
            });
        }

        if (typeof that.loopIteration === 'undefined')
            that.loopIteration = 0;

        var optionString = self.options[that.loopIteration] + ' (' + config[self.options[that.loopIteration]] + '): ';

        that.rl.question(optionString, function (answer) {
            self.newConfig[self.options[that.loopIteration]] = answer;
            that.loopIteration++;

            if (answer == 'exit' || that.loopIteration >= self.options.length) {
                if (typeof callback === 'function') callback();
                return that.rl.close();
            }

            self.loopConfigItems(callback);
        });
    };

    this.change = function () {
        console.log(chalk.bgMagenta("Let's update the configuration\n"));
        console.log("Press enter if you want to keep the current configuration of the parameter (between parentheses).\n");

        self.loopConfigItems(function () {
            for (var i = 0; i < self.options.length; i++) {
                if (self.newConfig[self.options[i]].match(/[ \t]+|^$/)) {
                    self.newConfig[self.options[i]] = config[self.options[i]];
                }
            }

            console.log();

            var data = JSON.stringify(self.newConfig);
            var fs = require('fs');

            fs.writeFile(path.normalize(path.dirname(__dirname) + '/config.json'), data, function (err) {
                if (err) {
                    error("There has been an error saving your configuration data. + \n" + err.message);
                }
                console.log(chalk.bgGreen('Configuration saved successfully.'));
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