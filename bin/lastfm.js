#!/usr/bin/env node

require('dotenv').config()

const lastfm = require('../src/lastfm')
const availableCommands = Object.keys(lastfm)

;(async () => {
  if (process.argv.length !== 3 || !availableCommands.includes(process.argv[2])) {
    console.log(`❌ Invalid command. Allowed commands: ${availableCommands.join(' ')}`)
    process.exit(1)
  }

  await lastfm[process.argv[2]]()
})()