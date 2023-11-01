var config = require('../../config.json'),
    divider = require('./divider.js'),
    chalk = require('chalk');

function welcome(title, description) {
    console.log();
    console.log(chalk.inverse(title));
    console.log();
    divider('*');
    console.log();
    console.log(description);
    console.log();
    divider('*');
    console.log();
}

module.exports = {
    backup: function () {
        var title = 'BACKUP TOOL',
            description = 'This tool is used to backup the hosts file. Answer to the questions in order to ' +
                'backup the hosts file located at ' + chalk.yellow(config.hosts) + '.';

        welcome(title, description);
    },
    config: function () {
        var title = "CONFIGURATION",
            description = "If you want to see or change the configuration of sitify, you're in the right place. Use " +
                "'-c' to change the configuration.";

        welcome(title, description);
    },
    hosts: function () {
        var title = "HOSTS TOOL",
            description = 'This tool is used to show the content of your hosts file by default or: wipe the data of' +
                ' the hosts file using -w option; or clean the file doing a rearrange using -c option.';

        welcome(title, description);
    },
    addThing: function () {
        var title = "NEW TOOL",
            description = 'Use this tool to create new entries in the hosts file (-e) or to create a new website' +
                ' folder structure (-w).';

        welcome(title, description);
    },
    removeThing: function () {
        var title = "REMOVE TOOL",
            description = 'Use this tool to remove entries of the hosts file (-e) or to remove an website (-w).';

        welcome(title, description);
    }
};