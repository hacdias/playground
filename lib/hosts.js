var config = require('../config.js'),
    error = require('../lib/error'),
    fs = require('fs');

var Hosts = function (action, projectName) {
    var self = this;

    if (action !== 'add' && action !== 'remove') error("Unavailable action.");

    this.action = action;
    this.keyword = (action === 'add') ? 'added' : 'removed';
    this.projectName = (typeof projectName !== 'undefined') ? projectName : null;

    this.begin = function () {
        fs.readFile(config.hosts, 'utf8', self.generateHosts);
    };

    this.generateHosts = function (err, data) {
        if (err) error(err);

        self.hostsFileContent = data;

        self.hostsOfThisProject = "\n127.0.0.1\t" + self.projectName + ".dev";
        self.hostsOfThisProject += "\n127.0.0.1\twww." + self.projectName + ".dev";

        if (self.action === 'add') self.hostsFileContent += self.hostsOfThisProject;
        if (self.action === 'remove') self.hostsFileContent = self.hostsFileContent.replace(self.hostsOfThisProject, "");

        fs.writeFile(config.hosts, self.hostsFileContent, 'utf8', self.writeHosts);
    };

    this.writeHosts = function (err) {
        if (err) error(err);
        console.log();
        console.log("The following entries were " + self.keyword + " to your hosts file:");
        console.log(self.hostsOfThisProject);
    }
};

module.exports = (function (action, justDoIt, projectName) {
    var hosts = new Hosts(action, justDoIt, projectName);
    hosts.begin();
});
