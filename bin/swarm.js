#!/usr/bin/env node

require('dotenv').config()

const swarm = require('../src/swarm')
const availableCommands = Object.keys(swarm)

;(async () => {
  if (process.argv.length !== 3 || !availableCommands.includes(process.argv[2])) {
    console.log(`❌ Invalid command. Allowed commands: ${availableCommands.join(' ')}`)
    process.exit(1)
  }

  await swarm[process.argv[2]]()
})()