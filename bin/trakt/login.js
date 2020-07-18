#!/usr/bin/env node

require('dotenv').config()

const login = require('../../src/login')

;(async () => {
  await login({
    port: process.env.PORT,
    config: {
      client: {
        id: process.env.TRAKT_ID,
        secret: process.env.TRAKT_SECRET
      },
      auth: {
        tokenHost: 'https://trakt.tv/oauth'
      }
    }
  })
})()
