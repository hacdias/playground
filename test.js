var shell = require('./');
shell('git add -A', {sync: true});
shell("git commit -m \"Some teste\"", {
  suppressblank: false,
  sync: true
});
