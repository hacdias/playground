require('dotenv').config()

const got = require('got')
const fs = require('fs')

const get = async (page) => {
  const url = `https://api.foursquare.com/v2/users/self/checkins?offset=${500 * page}&limit=500&oauth_token=${process.env.ACCESS_TOKEN}&v=20200217`
  console.log(url)
  const { body } = await got(url, {
    headers: {
      'Content-Type': 'application/json'
    },
    responseType: 'json'
  })

  return body
}

// https://api.foursquare.com/v2/checkins/CHECKIN_ID

;(async () => {
  const items = []

  for (let page = 0, res; (res = await get(page)) && res.response.checkins.items.length > 0; page++) {
    items.push(...res.response.checkins.items)
  }

  fs.writeFileSync('./history.json', JSON.stringify(items, null, 2))
})()
