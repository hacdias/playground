var config = require('../config.json'),
    error = require('./helpers/error.js'),
    path = require('path'),
    fs = require('fs'),
    read = require('readline'),
    chalk = require('chalk');

function Backup() {
    this.make = function () {

        var rli = read.createInterface({
            input: process.stdin,
            output: process.stdout
        });

        rli.question('Backup path (including the file name): ', function (result) {
            rli.close();
            path.normalize(result);

            fs.readFile(config.hosts, 'utf8', function (err, data) {
                if (err) error(err);

                fs.writeFile(result, data, 'utf8', function (err) {
                    if (err) error(err);
                    console.log(chalk.bgGreen("\nResult:"));
                    console.log('%s copied to %s.', chalk.cyan(config.hosts), chalk.green(path.resolve(result)));
                });
            });
        });
    }
}

module.exports = (function () {
    var backup = new Backup();
    backup.make();
});



