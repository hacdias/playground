const fs = require('fs')
const path = require('path')

const argv = process.argv
if (argv.length !== 3) {
  console.log('Directory is required as argument.')
  process.exit(1)
}

const dir = path.join(argv[2], 'single')

for (const test of fs.readdirSync(dir)) {
  const filename = path.join(dir, test, 'run.out')
  const data = fs.readFileSync(filename)
    .toString()
    .split('\n')
    .map(d => d.trim())
    .filter(d => d)
    .map(JSON.parse)
    .filter(d => d.event)
    .map(d => d.event)
    .filter(d => d.message_event)
    .map(d => d.message_event.message)
    .filter(d => typeof d === 'object')

  console.log(data)
}
