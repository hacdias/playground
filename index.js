'use strict';

function checkIf(thing, is, where, what) {
  if (typeof thing === is) {
    if (typeof where === 'undefined') {
      return true;
    } else {
      throw new SyntaxError('You have defined more than one ' + what);
    }
  } else {
    return;
  }
}

function parseArguments(args) {
  var opts = {};

  for (var i = args.length - 1; i > 0; i--) {
    if (checkIf(args[i], 'function', opts.callback, 'callback function')) {
      opts.callback = args[i];
      continue;
    }

    if (checkIf(args[i], 'object', opts.args, 'array of arguments')) {
      opts.args = args[i];
      continue;
    }

    if (checkIf(args[i], 'string', opts.cwd, 'working directory')) {
      opts.cwd = args[i];
    }
  }

  opts.cwd = (typeof opts.cwd === 'undefined') ? process.cwd() : opts.cwd;
  opts.args = (typeof opts.args === 'undefined') ? [] : opts.args;

  return opts;
}

module.exports = function (cmd /*, args, cwd, callback */) {
  var os = require('os'),
      path = require('path'),
      childProcess = require('child_process'),
      isWindows = os.platform() === 'win32',
      opts = parseArguments(arguments),
      args = opts.args,
      cwd = opts.cwd,
      callback = opts.callback;

  if (isWindows) {
    args.unshift(cmd);

    args = [
      '/s',
      '/c',
      args.join(' ')
    ];

    cmd = 'cmd.exe';
  }

  var child = childProcess.spawn(cmd, args, {
    cwd: cwd,
    env: process.env,
    stdio: 'inherit'
  });

  child.on('close', function(code) {
    if (typeof callback === 'function') {
      callback();
    }
  });
};
