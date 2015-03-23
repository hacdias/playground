var config = require('../config'),
    error = require('../lib/error'),
    path = require('path'),
    fs = require('fs'),
    modifyHosts = require('../lib/hosts');

var Website = function (action, projectName) {
    var self = this;

    this.action = action;
    this.projectName = projectName;
    this.projectDir = path.join(config.www, projectName);
    this.wwwDir = path.join(this.projectDir, config.wwwSub);

    this.begin = function() {
        if (action === 'add') this.add();
        if (action === 'remove') this.remove();
    };

    this.remove = function() {
        console.log("It isn't available yet.");

        /*fs.rmdir(self.projectDir, function() {
         hostsCommand('remove', self.projectName);
        }); */
    };

    this.add = function() {
        fs.mkdir(this.projectDir, function (err) {
            if (err) error(err);

            console.log();
            console.log(self.projectDir + " created.");

            fs.mkdir(self.wwwDir, function (err) {
                if (err) error(err);
                console.log(self.wwwDir + " created.");

                modifyHosts('add', self.projectName);
            });
        });
    };

};

module.exports = (function (action, projectName) {
    var website = new Website(action, projectName);
    website.begin();
});
