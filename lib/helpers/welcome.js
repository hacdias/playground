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

module.exports = (function (title, description) {
    welcome(title, description);
});