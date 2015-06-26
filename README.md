# WPSync

[![Build](https://img.shields.io/travis/hacdias/wpsync-cli.svg?style=flat-square)](https://travis-ci.org/hacdias/wpsync-cli)
[![Latest Stable Release](https://img.shields.io/github/release/hacdias/wpsync-cli.svg?style=flat-square)](https://github.com/hacdias/wpsync-cli/releases)
[![License](https://img.shields.io/github/license/hacdias/wpsync-cli.svg?style=flat-square)](https://github.com/hacdias/wpsync-cli/blob/master/LICENSE)

Do you use a GitHub, or any other git or svn repository, for the development of your WordPress plugin? Are you bored of copying and pasting all of the files when you launch a new version of your plugin? Are you bored of changing the plugin version every time? This is the perfect solution for you!

### Menu

- [Features](#features)
- [Installation](#installation)
  + [Linux and OS X](#linux-and-os-x)
  + [Windows](#windows)

## Features

* Updates [bower](https://github.com/bower/bower) and [composer](https://github.com/composer/composer) dependencies;
* Edits the files and sets the new version of the plugin;
* Updates both DEV and WP SVN repositories, creating a tag;
* Ignores the folders/files you want.

## Installation

Go to [downloads page](https://github.com/hacdias/wpsync-cli/releases) and download the package for your operating system and architecture. Then, unzip the files, and put the executable somewhere covered by PATH variable.

### Linux and OS X

Just run the following commands, replacing ```$VERSION``` by the current version, ```$OS``` by your operating system name and ```$ARCH``` by your operating system's architecture.

```bash
curl -LOk https://github.com/hacdias/wpsync-cli/releases/download/$VERSION/$OS_$ARCH.zip
unzip wpsync_$OS_$ARCH.zip
sudo cp wpsync /usr/local/bin
```

### Windows

After downloading the zip folder, unzip it. Then, execute ```install.bat``` as admin.

## Usage

You should run the command ```wpsync init --link="WORDPRESS_SVN_URL"``` in the root of your project. It will create a ```wpsync.json``` file. Should have a content like this:

```json
{
  "increase": "build",
  "plugin": {
    "main": "plugin.php",
    "readme": "readme.txt",
    "svn": "https://plugins.svn.wordpress.org/hackerrank-profile-widget/",
  },
  "dependencies": {
    "bower": true,
    "composer": true
  },
  "ignore": [
    ".idea"
  ]
}

```

* ```increase``` is the default version increase (nomenclature: ```major.minor[.build[.revision]]```);

* ```main``` and ```readme``` refers to the plugin's main file and its readme.

* ```svn``` is the link for the WordPress SVN;

* ```ignore``` is an array of files/folders you don't want to upload to the WordPress SVN.

After having a ```.wpsync``` file on the root of your project, you just have to run the following command from console:

```
wpsync [commands] [options]
```

Run ```wpsync -h``` to know more.
