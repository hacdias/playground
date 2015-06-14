var shell = require('./');
shell('git add -A', {sync: true});
shell("git", ['commit', '-m', '"some message"'], {
  suppressblank: false,
  sync: true
});
