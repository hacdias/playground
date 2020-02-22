#!/usr/bin/env node

require('dotenv').config()

const got = require('got')
const fs = require('fs-extra')
const path = require('path')

async function get (page) {
  const { headers, body } = await got(`https://api.trakt.tv/sync/history?page=${page}&limit=500&extended=full`, {
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

;(async () => {
  const items = []
  const dataDir = path.join(process.env.DATA_DIR, 'raw')
  await fs.ensureDir(dataDir)

  for (let page = 1, res; (res = await get(page)) && res.totalPages >= page; page++) {
    console.log(`Page ${page} downloaded with ${res.body.length} items.`)
    items.push(...res.body)
  }

  console.log(`${items.length} items downloaded.`)
  fs.writeFileSync(path.join(dataDir, 'history.json'), JSON.stringify(items, null, 2))
})()
