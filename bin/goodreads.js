#!/usr/bin/env node

require('dotenv').config()

const goodreads = require('../src/goodreads')
const availableCommands = Object.keys(goodreads)

;(async () => {
  if (process.argv.length !== 3 || !availableCommands.includes(process.argv[2])) {
    console.log(`❌ Invalid command. Allowed commands: ${availableCommands.join(' ')}`)
    process.exit(1)
  }

  await goodreads[process.argv[2]]()
})()