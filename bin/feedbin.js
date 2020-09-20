#!/usr/bin/env node

require('dotenv').config()

const feedbin = require('../src/feedbin')
const availableCommands = Object.keys(feedbin)

;(async () => {
  if (process.argv.length !== 3 || !availableCommands.includes(process.argv[2])) {
    console.log(`❌ Invalid command. Allowed commands: ${availableCommands.join(' ')}`)
    process.exit(1)
  }

  await feedbin[process.argv[2]]()
})()
