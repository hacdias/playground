require('dotenv').config()

const got = require('got')
const fs = require('fs')

const get = async (page) => {
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

;(async () => {
  const items = []

  for (let page = 1, res; (res = await get(page)) && res.totalPages >= page; page++) {
    items.push(...res.body)
  }

  fs.writeFileSync('./history.json', JSON.stringify(items, null, 2))
})()
