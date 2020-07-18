#!/usr/bin/env node

require('dotenv').config()

const trakt = require('../src/trakt')
const availableCommands = Object.keys(trakt)

;(async () => {
  if (process.argv.length !== 3 || !availableCommands.includes(process.argv[2])) {
    console.log(`❌ Invalid command. Allowed commands: ${availableCommands.join(' ')}`)
    process.exit(1)
  }

  await trakt[process.argv[2]]()
})()