var config = require('../config'),
    divider = require('./helpers/divider'),
    error = require('./helpers/error'),
    fs = require('fs'),
    read = require('readline'),
    welcome = require('./helpers/welcome'),
    chalk = require('chalk');

var arrayUnique = function (array) {
    return array.reduce(function (accum, current) {
        if (accum.indexOf(current) < 0) {
            accum.push(current);
        }
        return accum;
    }, []);
};

var Hosts = function () {
    var self = this;

    this.welcome = function () {
        this.title = "HOSTS TOOL";
        this.description = 'This tool is used to show the content of your hosts file by default or: wipe the data of' +
        ' the hosts file using -w option; or clean the file doing a rearrange using -c option.';

        welcome(this.title, this.description);
    };

    this.clean = function () {
        self.welcome();

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

            domains = arrayUnique(domains);

            // change current project name and generate its hosts entries
            for (var y = 0; y < domains.length; y++) {
                self.projectName = domains[y];
                self.generateHosts('');
            }

            console.log(chalk.bgYellow("Check if everything is correct.\n"));
            divider('#');
            console.log(self.hostsFileContent);
            divider('#');

            var readInterface = read.createInterface({
                input: process.stdin,
                output: process.stdout
            });

            var question = "\nAre you sure you want to override " + chalk.yellow(config.hosts) + "? (Y/N) ";

            readInterface.question(question, function (result) {
                readInterface.close();

                if (result === 'y' || result === 'Y') {
                    fs.writeFile(config.hosts, self.hostsFileContent, 'utf8', function (err) {
                        if (err) error(err);

                        console.log(chalk.green('Successfully completed.'));
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

        // TODO: confirm if already exists

        self.hostsOfThisProject = "127.0.0.1\t" + self.projectName + "." + config.tld + "\n";
        self.hostsOfThisProject += "127.0.0.1\twww." + self.projectName + "." + config.tld + "\n\n";

        if (self.action === 'add') self.hostsFileContent += self.hostsOfThisProject;
        if (self.action === 'remove') self.hostsFileContent = self.hostsFileContent.replace(self.hostsOfThisProject, "");

        if (typeof callback === 'function') callback();
    };

    this.show = function () {
        self.welcome();

        fs.readFile(config.hosts, 'utf8', function (err, data) {
            if (err) error(err);

            if (data.match(/[ \t]+|^$/)) {
                console.log("The file %s is empty.", chalk.yellow(config.hosts));
                return;
            }

            console.log("Here is the content of the hosts file located at %s.\n", chalk.yellow(config.hosts));
            divider("#");
            console.log(data);
            divider("#");
        });
    };

    this.wipe = function () {
        self.welcome();

        var readInterface = read.createInterface({
            input: process.stdin,
            output: process.stdout
        });

        var question = "Are you sure you want to wipe the file " + chalk.yellow(config.hosts) + "? (Y/N) ";

        readInterface.question(question, function (result) {
            readInterface.close();

            if (result === 'y' || result === 'Y') {
                fs.writeFile(config.hosts, "", 'utf8', function (err) {
                    if (err) error(err);
                    console.log(chalk.green('Successfully completed.'));
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
