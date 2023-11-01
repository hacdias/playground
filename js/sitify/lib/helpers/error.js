var chalk = require('chalk');

module.exports = (function (err) {
    console.log(chalk.bgRed("\nError:"));
    console.error("%s", err);
    process.exit(1);
});