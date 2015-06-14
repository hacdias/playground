var shell = require('./');
shell('git add -A', {sync: true});
shell("git commit -m 'Some'", {
  suppressblank: false,
  sync: true
});
