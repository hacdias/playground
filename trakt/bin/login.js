#!/usr/bin/env node

require('dotenv').config()

const express = require('express')
const simpleOAuth = require('simple-oauth2')

;(async () => {
  const credentials = {
    client: {
      id: process.env.TRAKT_ID,
      secret: process.env.TRAKT_SECRET
    },
    auth: {
      tokenHost: 'https://trakt.tv/oauth'
    }
  }

  const callback = `http://localhost:${process.env.PORT}/callback`
  const oauth2 = simpleOAuth.create(credentials)
  const authorizationUri = oauth2.authorizationCode.authorizeURL({ redirect_uri: callback })

  console.log('Open the URL bellow:')
  console.log(authorizationUri)

  const app = express()

  app.get('/callback', async function (req, res) {
    const tokenConfig = {
      code: req.query.code,
      redirect_uri: callback
    }

    let code = 0

    try {
      const result = await oauth2.authorizationCode.getToken(tokenConfig)
      const accessToken = oauth2.accessToken.create(result)
      console.log(`\nACCESS_TOKEN=${accessToken.token.access_token}`)
    } catch (error) {
      code = 1
      console.log('\nCould not get access token:', error.message)
    }

    res.set('Content-Type', 'text/html')
    res.send(Buffer.from('<!DOCTYPE html><html><head></head><body><h1>Please close this page and go back to the CLI.</h1><script>window.close();</script></body></html>'))
    server.close()
    process.exit(code)
  })

  const server = app.listen(process.env.PORT)
})()
