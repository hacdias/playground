# WPSync

![Latest Tag](https://img.shields.io/github/tag/hacdias/wpsync.svg?style=flat-square)
![Latest Release](https://img.shields.io/github/release/hacdias/wpsync.svg?style=flat-square)
![License](https://img.shields.io/github/license/hacdias/wpsync.svg?style=flat-square)

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

Go to [downloads page](https://github.com/hacdias/wpsync/releases) and download the package for your operating system and architecture. Then, unzip the files, and put the executable somewhere covered by PATH variable.

### Linux and OS X

Just run the following commands, replacing ```$VERSION``` by the current version, ```$YSTEM``` by your operating system name and ```$ARCH``` by your operating system's architecture.

```bash
curl -LOk https://github.com/hacdias/wpsync/releases/download/$VERSION/wpsync_$YSTEM_$ARCH.zip
unzip wpsync_$YSTEM_$ARCH.zip
sudo cp wpsync /usr/local/bin
```

### Windows

After downloading the zip folder, unzip it. Then, execute ```install.bat``` as admin.

## Usage

You need to create a ```.wpsync``` file in the root of your project. Should have a content like this:

```json
{
  "increase": "build",
  "main": "plugin.php",
  "readme": "readme.txt",
  "wordpress-svn": "https://plugins.svn.wordpress.org/hackerrank-profile-widget/",
  "ignore": [
    ".git",
    ".idea"
  ]
}
```

* ```increase``` is the default version increase (nomenclature: ```major.minor[.build[.revision]]```);

* ```main``` and ```readme``` refers to the plugin's main file and its readme.

* ```wordpress-svn``` is the link for the WordPress SVN;

* ```ignore``` is an array of files/folders you don't want to upload to the WordPress SVN.

After having a ```.wpsync``` file on the root of your project, you just have to run the following command from console:

```
wpsync [commands] [options]
```

Run ```wpsync -h``` to know more.
