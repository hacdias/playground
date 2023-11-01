#!/usr/bin/env node

require('dotenv').config()

const services = require('.')

;(async () => {
  if (process.argv.length !== 4) {
    console.log('❌ Invalid command. It should be in the format: <service> <command>')
    process.exit(1)
  }

  const service = process.argv[2]
  const command = process.argv[3]

  if (!services[service]) {
    console.log(`❌ Invalid command. Service '${service}' not found.`)
    process.exit(1)
  }

  const availableCommands = Object.keys(services[service])

  if (!availableCommands.includes(command)) {
    console.log(`❌ Invalid command. Command '${command}' not found for service '${service}'.`)
    process.exit(1)
  }

  await services[service][command]()
})()
