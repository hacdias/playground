#!/usr/bin/env node

require('dotenv').config()

const got = require('got')
const path = require('path')
const fs = require('fs-extra')
const convert = require('../src/convert')

const client = got.extend({
  prefixUrl: 'https://api.github.com',
  username: process.env.GITHUB_USERNAME,
  password: process.env.GITHUB_TOKEN,
  responseType: 'json'
})

;(async () => {
  const src = path.join(process.env.DATA_DIR, 'history.json')
  const rawHistory = fs.readJSONSync(src)

  const history = convert(rawHistory)
  const historyEncoded = Buffer.from(JSON.stringify(history, null, 2)).toString('base64')

  const get = await client(`repos/${process.env.GITHUB_REPO}/contents/${process.env.GITHUB_PATH}`)

  const oldHistory = get.body.content.split('\n').join('').trim()

  if (oldHistory === historyEncoded) {
    console.log('history already up to date')
    return
  }

  await client.put(`repos/${process.env.GITHUB_REPO}/contents/${process.env.GITHUB_PATH}`, {
    json: {
      message: `${new Date().toUTCString()} update watches`,
      content: historyEncoded,
      sha: get.body.sha
    }
  })

  console.log('Updated')
})()
