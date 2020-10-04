#!/usr/bin/env node

require('dotenv').config()

const miniflux = require('../src/miniflux')
const availableCommands = Object.keys(miniflux)

;(async () => {
  if (process.argv.length !== 3 || !availableCommands.includes(process.argv[2])) {
    console.log(`❌ Invalid command. Allowed commands: ${availableCommands.join(' ')}`)
    process.exit(1)
  }

  await miniflux[process.argv[2]]()
})()
