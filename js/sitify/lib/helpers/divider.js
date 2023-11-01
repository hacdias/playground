module.exports = (function (char) {
    for (var i = 0; i < process.stdout.columns; i++) {
        process.stdout.write(char);
    }
});