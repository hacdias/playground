var sitify = require('commander'),
    prompt = require('prompt'),
    fs = require('fs'),
    path = require('path');

var devDir = sitify_config_devDir,
    hostsFile = sitify_config_hostsFile;

sitify
    .version('0.0.1')
    .option('-b, --backup', 'Backup Hosts File')
    .option('-n, --new', 'Create a New Website')
    .option('-c, --config', 'Configuration')
    .parse(process.argv);

printLogo();

if (sitify.backup) backupHostsFile();
if (sitify.new) newWebsite();

function backupHostsFile()
{
    prompt.message = '';
    prompt.delimiter = '';

    prompt.start();

    prompt.get({
        properties: {
            path: {
                description: "Insert the backup path:"
            }
        }
    }, function (err, result) {

        if (err) error(err);
        path.normalize(result.path);

        fs.readFile(hostsFile, 'utf8', function(err, data){

            if (err) error(err);
            hostsContent = data;

            fs.writeFile(result.path, hostsContent, 'utf8', function(err) {

                if (err) error(err);
                console.log(hostsFile + " copied to " + path.resolve(result.path) + ".\n");

            });
        });
    });
}

function newWebsite()
{
    prompt.message = '';
    prompt.delimiter = '';

    prompt.start();

    prompt.get({
        properties: {
            name: {
                description: "Please insert the name of your new web project: "
            }
        }
    }, function (err, project) {

        if (err) error(err);

        projectDir = path.join(devDir, project.name);
        wwwDir = path.join(projectDir, 'wwwroot');

        console.log();

        fs.mkdir(projectDir, function(err) {
            if (err) error(err);
            console.log(projectDir + " created.");

            fs.mkdir(wwwDir, function(err) {
                if (err) error(err);
                console.log(wwwDir + " created.");

                fs.readFile(hostsFile, 'utf8', function(err, data){

                    if (err) error(err);
                    hostsContent = data;

                    hostsToAdd = "\n127.0.0.1\t" + project.name + ".dev";
                    hostsToAdd += "\n127.0.0.1\twww." + project.name + ".dev\n";

                    hostsContent += hostsToAdd;

                    fs.writeFile(hostsFile, hostsContent, 'utf8', function(err) {

                        if (err) error(err);
                        console.log();
                        console.log("The following entries were added to your hosts file:");
                        console.log(hostsToAdd);

                    });
                });
            });
        });
    });
}

function error(err)
{
    console.error("%s", err);
    process.exit(1);
}

function printLogo()
{
    var logo = [
        "                    ____        __           ___             ",
        "                   /\\  _`\\   __/\\ \\__  __  /'___\\            ",
        "                   \\ \\,\\L\\_\\/\\_\\ \\ ,_\\/\\_\\/\\ \\__/  __  __    ",
        "                    \\/_\\__ \\\\/\\ \\ \\ \\/\\/\\ \\ \\ ,__\\/\\ \\/\\ \\   ",
        "                      /\\ \\L\\ \\ \\ \\ \\ \\_\\ \\ \\ \\ \\_/\\ \\ \\_\\ \\  ",
        "                      \\ `\\____\\ \\_\\ \\__\\\\ \\_\\ \\_\\  \\/`____ \\ ",
        "                       \\/_____/\\/_/\\/__/ \\/_/\\/_/   `/___/> \\",
        "                                                       /\\___/",
        "                                                       \\/__/ "
    ];

    console.log();
    for (var i = 0; i < logo.length; i++) {
        console.log(logo[i]);
    }
    console.log();
}
