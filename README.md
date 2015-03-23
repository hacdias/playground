# What is Sitify? [![npm version](https://badge.fury.io/js/sitify.svg)](http://badge.fury.io/js/sitify) [![GitHub version](https://badge.fury.io/gh/hacdias%2Fsitify.svg)](http://badge.fury.io/gh/hacdias%2Fsitify)

[![NPM](https://nodei.co/npm/sitify.png?downloads=true)](https://nodei.co/npm/sitify/)

If you, like me, have a dynamic web projects environment, it means, if you have something like this on your Apache configurations (or whatever you use):

```Apache
<Virtualhost *:80>
    VirtualDocumentRoot "D:/Dev/www/%1/wwwroot"
    ServerName sites.dev
    ServerAlias *.dev
    UseCanonicalName Off
</Virtualhost>
```

You know that if you go to ```webproj.dev``` it will show you the content of the ```D:/Dev/www/webproj/wwwroot``` folder. It is dynamic.

After mounted this system, I wanted for a tool which function is the automatic creation of those folders and the respective ```hosts``` entry.

# Installation

Firstly, make sure if you have Node.js installed. After that you should run:

```bash
$ [sudo] npm install sitify -g
```

# Usage

First of all, you must configure Sitify. To do it you should run the following command and set all of the configurations:

```bash
$ sitify config
```
