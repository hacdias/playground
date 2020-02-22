#!/usr/bin/env node

require('dotenv').config()

const express = require('express')
const got = require('got')
const fs = require('fs')
const path = require('path')

const args = process.argv.slice(2)
const command = args[0]

;(async () => {
  switch (command) {
    case 'login':
      await login()
      break
    case 'sync':
      await sync()
      break
    default:
      console.log('Invalid command: ' + command)
      process.exit(1)
  }
})()

async function login () {
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
  const oauth2 = require('simple-oauth2').create(credentials)
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
}

async function get (page) {
  const { headers, body } = await got(`https://api.trakt.tv/sync/history?page=${page}&limit=500`, {
    headers: {
      'Content-Type': 'application/json',
      'trakt-api-key': process.env.TRAKT_ID,
      'trakt-api-version': '2',
      Authorization: `Bearer ${process.env.ACCESS_TOKEN}`
    },
    responseType: 'json'
  })

  const totalPages = parseInt(headers['x-pagination-page-count'])
  return { body, totalPages }
}

async function sync () {
  const items = []

  for (let page = 1, res; (res = await get(page)) && res.totalPages >= page; page++) {
    items.push(...res.body)
  }

  fs.writeFileSync(path.join(process.env.OUTPUT_DIRECTORY, 'history.json'), JSON.stringify(items, null, 2))
}
