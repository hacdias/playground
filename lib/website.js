var config = require('../config'),
    error = require('./helpers/error'),
    path = require('path'),
    fs = require('fs'),
    hosts = require('./hosts'),
    chalk = require('chalk');

var Website = function () {
    var self = this;

    this.make = function (action, projectName) {
        this.action = action;
        this.projectName = projectName;
        this.projectDir = path.join(config.www, projectName);
        this.wwwDir = path.join(this.projectDir, config.wwwSub);

        if (action === 'add') this.add();
        if (action === 'remove') this.remove();
    };

    this.add = function () {
        fs.mkdir(this.projectDir, function (err) {
            if (err) error(err);

            console.log(chalk.cyan(self.projectDir) + " created.");

            fs.mkdir(self.wwwDir, function (err) {
                if (err) error(err);

                console.log(chalk.cyan(self.wwwDir) + " created.\n");
                hosts().make('add', self.projectName);
            });
        });
    };

    this.remove = function () {
        console.log("It isn't available yet.");
    };
};

module.exports = (function () {
    var website = new Website();

    return {
        make: function (action, projectName) {
            website.make(action, projectName);
        }
    }
});
