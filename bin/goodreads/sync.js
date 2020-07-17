#!/usr/bin/env node

require('dotenv').config()

const got = require('got')
const xml2js = require('xml2js')
const updateGithub = require('../../src/update-github')

async function fetch () {
  const items = []
  let page = 1
  let end
  let total

  do {
    const { body } = await got(`https://www.goodreads.com/review/list/${process.env.GOODREADS_USER}.xml?key=${process.env.GOODREADS_API_ID}&v=2&per_page=200&page=${page}`)
    const data = await xml2js.parseStringPromise(body)
    end = data.GoodreadsResponse.reviews[0].$.end
    total = data.GoodreadsResponse.reviews[0].$.total
    items.push(...data.GoodreadsResponse.reviews[0].review)
    page++
  } while (end !== total)

  return items
}

async function parse (data) {
  const books = {}

  for (const item of data) {
    const shelf = item.shelves[0].shelf[0].$.name

    const book = {
      date: item.read_at[0] || item.started_at[0] || null,
      author: item.book[0].authors[0].author[0].name[0],
      name: item.book[0].title[0],
      isbn: item.book[0].isbn13[0],
      rating: Number(item.rating[0]) || 'N/A'
    }

    if (book.date) {
      book.date = new Date(book.date)
    }

    book.name = book.name.replace(/\(.*#.*\)/g, '').trim()
    books[shelf] = books[shelf] || []
    books[shelf].push(book)
  }

  return books
}

;(async () => {
  console.log('📚 Fetching from GoodReads...')
  const raw = await fetch()
  const data = await parse(raw)
  const json = JSON.stringify(data, null, 2)

  await updateGithub({
    data: json,
    repo: process.env.GOODREADS_GITHUB_REPO,
    path: process.env.GOODREADS_GITHUB_PATH,
    message: `${new Date().toUTCString()} update reads`
  })
})()
