#!/usr/bin/env node

require('dotenv').config()

const login = require('../../src/login')

;(async () => {
  await login({
    port: process.env.PORT,
    config: {
      client: {
        id: process.env.FOURSQUARE_ID,
        secret: process.env.FOURSQUARE_SECRET
      },
      auth: {
        tokenPath: '/oauth2/access_token',
        revokePath: '/oauth2/revoke',
        authorizePath: '/oauth2/authorize',
        tokenHost: 'https://foursquare.com/'
      }
    }
  })
})()
