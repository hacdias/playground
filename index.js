'use strict';

var os = require('os');
var childProcess = require('child_process');
var isWindows = os.platform() === 'win32';

var InteractiveShell = function(cmd /*, args, opts, callback */) {
  if (typeof cmd === 'undefined') {
    throw new SyntaxError('You must pass a command');
  }

  var opts = this.parseArguments(arguments);
  this.cmd = cmd;
  this.opts = opts.opts;
  this.args = opts.args;
  this.callback = opts.callback;
}

InteractiveShell.prototype.parseArguments = function (args) {
  var opts = {};

  var types = {
    args: 'array',
    opts: 'object',
    callback: 'function'
  }

  for (var i = 1; i < args.length; i++) {
      for (var name in types) {
        if (types[name] === 'array' && Array.isArray(args[i])) {
          opts[name] = args[i];
          break;
        }

        if (typeof args[i] === types[name]) {
          opts[name] = args[i];
        }
      }
  }

  if (!opts.args) opts.args = [];
  if (!opts.callback) opts.callback = function() {};
  if (!opts.opts) opts.opts = {};

  opts.opts = this.parseOptions(opts.opts);
  return opts;
};

InteractiveShell.prototype.parseOptions = function (opts) {
  var defaultOptions = {
    cwd: process.cwd(),
    sync: false,
    suppressblank: true
  }

  for (var thing in defaultOptions) {
    if (typeof opts[thing] === 'undefined') {
      opts[thing] = defaultOptions[thing];
    }
  }

  return opts;
};

InteractiveShell.prototype.shell = function () {
  console.log(this);

  if (isWindows) {
    this.args.unshift(this.cmd);
    this.args.unshift('/c');

    if (this.opts.suppressblank) {
      this.args.unshift('/s');
    }

    this.cmd = 'cmd.exe';
  }

  var shellOpts = {
    cwd: this.opts.cwd,
    env: process.env,
    stdio: 'inherit'
  };

  var callback = this.callback;

  if (this.opts.sync) {
    var child = childProcess.spawnSync(this.cmd, this.args, shellOpts);
    callback();
  } else {
    var child = childProcess.spawn(this.cmd, this.args, shellOpts);

    child.on('close', function(code) {
      callback();
    });
  }
};

module.exports = function() {

  var createInstance = (function() {
      function F(args) {
          return InteractiveShell.apply(this, args);
      }
      F.prototype = InteractiveShell.prototype;

      return function(args) {
          return new F(args);
      }
  })();

  var shell = createInstance(arguments);
  shell.shell();
}
