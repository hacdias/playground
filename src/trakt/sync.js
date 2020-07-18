const got = require('got')
const fs = require('fs-extra')
const path = require('path')
const convert = require('./convert')
const updateGitHub = require('../update-github')

const traktId = process.env.TRAKT_ID
const accessToken = process.env.TRAKT_ACCESS_TOKEN
const githubRepo = process.env.TRAKT_GITHUB_REPO
const githubPath = process.env.TRAKT_GITHUB_PATH
const dataDir = path.join(process.env.DATA_DIR, 'trakt')

async function get (page) {
  const { headers, body } = await got(`https://api.trakt.tv/sync/history?page=${page}&limit=500&extended=full`, {
    headers: {
      'Content-Type': 'application/json',
      'trakt-api-key': traktId,
      'trakt-api-version': '2',
      Authorization: `Bearer ${accessToken}`
    },
    responseType: 'json'
  })

  const totalPages = parseInt(headers['x-pagination-page-count'])
  return { body, totalPages }
}

module.exports = async function () {
  const items = []
  const historyPath = path.join(dataDir, 'history.json')

  for (let page = 1, res; (res = await get(page)) && res.totalPages >= page; page++) {
    console.log(`⬇️  Page ${page} downloaded with ${res.body.length} items.`)
    items.push(...res.body)
  }

  console.log(`✅ ${items.length} items downloaded.`)
  fs.writeFileSync(historyPath, JSON.stringify(items, null, 2))

  // GitHub updater...
  const rawHistory = fs.readJSONSync(historyPath)
  const history = convert(rawHistory)

  await updateGitHub({
    data: JSON.stringify(history, null, 2),
    repo: githubRepo,
    path: githubPath,
    message: `${new Date().toUTCString()} update watches`,
  })
}
