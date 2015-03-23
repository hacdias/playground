var config = require('../config.json'),
    error = require('../lib/error.js'),
    path = require('path'),
    fs = require('fs'),
    read = require('readline');

function Backup() {
    var rli = read.createInterface({
        input: process.stdin,
        output: process.stdout
    });

    rli.question("Insert the backup path: ", function (result) {
        rli.close();
        path.normalize(result);

        fs.readFile(config.hosts, 'utf8', function (err, data) {
            if (err) error(err);

            fs.writeFile(result, data, 'utf8', function (err) {
                if (err) error(err);
                console.log(config.hosts + " copied to " + path.resolve(result) + ".");
            });
        });
    });
}
module.exports = (function () {
    Backup();
});



