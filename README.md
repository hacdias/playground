# WPSync

Do you use a GitHub, or any other git or svn repository, for the development of your WordPress plugin? Are you bored of copying and pasting all of the files when you launch a new version of your plugin? Are you bored of changing the plugin version every time? This is the perfect solution for you!

## Features

Short version:

* Setting the new version of the plugin;
* Updating the WordPress SVN;
* Updating the development repository (git or svn);
* And more.

Long version:

* Update the bower and composer files;
* Check the current version of your plugin;
* Set the new version of your plugin, updating ```readme.txt``` and ```plugin.php``` files;
* Update the WordPress SVN trunk and create a new tag;
* Update the Git/SVN repository, tagging it;
* Ignore the files/folders you don't want to put in the WordPress SVN repository (like bower and composer setup files);

## Installation

TODO

## Usage

Firstly, you need to create a ```wpsync.json``` file like this:

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

The first element (```increase```) is used to set the default increase type on the version. By default it's used ```build```. The nomenclature is the following:

```
major.minor[.build[.revision]]
```

The elements in ```plugin``` section are very obvious.

The ```ignore``` section is one of the most interesting here. You can add the folders (or files) you don't want to upload to the SVN repository.

Example: you use bower, but you don't want the users to download ```bower.json``` everytime they download the plugin. So you can ignore it here.

The ```wordpress-svn``` element consists on the permanent link to the plugin's SVN repository. You must put ```trunk``` in the end of the URL.

Then you just have to run ```wpsync``` on the directory of you plugin.

## Do you have ideas?

Tell us in the issues section.
