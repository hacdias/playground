var shell = require('./');
shell('git add -A');
shell('git commit -m "Some updates"', {
  suppressblank: true
});
