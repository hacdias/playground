var config = require('../config'),
    error = require('../lib/error'),
    fs = require('fs'),
    read = require('readline'),
    divider = require('../lib/divider');

Array.prototype.unique = function () {
    return this.reduce(function (accum, current) {
        if (accum.indexOf(current) < 0) {
            accum.push(current);
        }
        return accum;
    }, []);
};

var Hosts = function () {
    var self = this;

    this.clean = function () {
        fs.readFile(config.hosts, 'utf8', function (err, data) {
            if (err) error(err);

            self.action = 'add';
            data = data.split(/[\t\n ]+/);

            var isEntry = new RegExp('^(www\.)?.+(.' + config.tld + ')$'),
                entries = [],
                domains = [];

            // add every line of hosts which is a valid entry to the entries var
            for (var i = 0; i < data.length; i++) {
                if (data[i].match(isEntry)) entries.push(data[i]);
            }

            // remove, on the domains var, the "www." and the final tld
            for (var x = 0; x < entries.length; x++) {
                domains[x] = entries[x].replace('www.', '');
                domains[x] = domains[x].replace('.' + config.tld, '');
            }

            domains = domains.unique();

            for (var y = 0; y < domains.length; y++) {
                // change current project name and generate its hosts entries
                self.projectName = domains[y];
                self.generateHosts('');
            }

            console.log("The new hosts file content. Check if everything is correct.");
            divider('#');
            console.log(self.hostsFileContent);
            divider('#');

            var readInterface = read.createInterface({
                input: process.stdin,
                output: process.stdout
            });

            readInterface.question("Are you sure you want to override the file " + config.hosts + "? (Y/N) ", function (result) {
                readInterface.close();

                if (result === 'y' || result === 'Y') {
                    fs.writeFile(config.hosts, self.hostsFileContent, 'utf8', function (err) {
                        if (err) error(err);

                        console.log("Process completed.");
                    });
                } else {
                    process.exit(0);
                }
            });
        });
    };

    this.make = function (action, projectName) {
        if (action !== 'add' && action !== 'remove') error("Unavailable action.");

        this.action = action;
        this.keyword = (action === 'add') ? 'added' : 'removed';
        this.projectName = (typeof projectName !== 'undefined') ? projectName : null;

        fs.readFile(config.hosts, 'utf8', function (err, data) {
            if (err) error(err);

            self.generateHosts(data, function () {
                fs.writeFile(config.hosts, self.hostsFileContent, 'utf8', function () {
                    if (err) error(err);
                    console.log();
                    console.log("The following entries were " + self.keyword + " to your hosts file:");
                    console.log(self.hostsOfThisProject);
                });
            });
        });
    };

    this.generateHosts = function (data, callback) {
        self.hostsFileContent = (typeof self.hostsFileContent !== 'undefined') ? self.hostsFileContent : data;

        self.hostsOfThisProject = "127.0.0.1\t" + self.projectName + "." + config.tld + "\n";
        self.hostsOfThisProject += "127.0.0.1\twww." + self.projectName + "." + config.tld + "\n\n";

        if (self.action === 'add') self.hostsFileContent += self.hostsOfThisProject;
        if (self.action === 'remove') self.hostsFileContent = self.hostsFileContent.replace(self.hostsOfThisProject, "");

        if (typeof callback === 'function') callback();
    };

    this.show = function () {
        fs.readFile(config.hosts, 'utf8', function (err, data) {
            if (err) error(err);

            console.log("\nHere is the content of the hosts file located at %s.", config.hosts);
            console.log(data);
        });
    };

    this.wipe = function () {
        var readInterface = read.createInterface({
            input: process.stdin,
            output: process.stdout
        });

        readInterface.question("Are you sure you want to wipe the file " + config.hosts + "? (Y/N) ", function (result) {
            readInterface.close();

            if (result === 'y' || result === 'Y') {
                fs.writeFile(config.hosts, "", 'utf8', function (err) {
                    if (err) error(err);
                });
            } else {
                process.exit(0);
            }
        });
    };
};

module.exports = (function () {
    var hosts = new Hosts();

    return {
        clean: function () {
            hosts.clean();
        },
        make: function (action, projectName) {
            hosts.make(action, projectName);
        },
        show: function () {
            hosts.show();
        },
        wipe: function () {
            hosts.wipe();
        }
    }
});
