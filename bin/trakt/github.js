#!/usr/bin/env node

require('dotenv').config()

const path = require('path')
const fs = require('fs-extra')
const convert = require('../../src/convert-trakt')
const updateGitHub = require('../../src/update-github')

;(async () => {
  const src = path.join(process.env.TRAKT_DATA_DIR, 'history.json')
  const rawHistory = fs.readJSONSync(src)
  const history = convert(rawHistory)

  await updateGitHub({
    data: JSON.stringify(history, null, 2),
    repo: process.env.TRAKT_GITHUB_REPO,
    path: process.env.TRAKT_GITHUB_PATH,
    message: `${new Date().toUTCString()} update watches`,
  })
})()
