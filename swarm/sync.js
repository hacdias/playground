const got = require('got')
const path = require('path')
const fs = require('fs-extra')

const get = async (page, accessToken) => {
  const url = `https://api.foursquare.com/v2/users/self/checkins?offset=${250 * page}&limit=250&oauth_token=${accessToken}&v=20200222`
  const { body } = await got(url, {
    headers: {
      'Content-Type': 'application/json'
    },
    responseType: 'json'
  })

  return body
}

const getID = async (id, accessToken) => {
  const url = `https://api.foursquare.com/v2/checkins/${id}?oauth_token=${accessToken}&v=20200222`
  const { body } = await got(url, {
    headers: {
      'Content-Type': 'application/json'
    },
    responseType: 'json'
  })

  return body.response.checkin
}

module.exports = async function () {
  const dataDir = path.join(process.env.DATA_DIR, 'swarm')
  const accessToken = path.join(process.env.FOURSQUARE_ACCESS_TOKEN)

  const singleDir = path.join(dataDir, 'single')
  const historyFile = path.join(dataDir, 'history.json')

  const items = []

  for (let page = 0, res; (res = await get(page, accessToken)) && res.response.checkins.items.length > 0; page++) {
    console.log(`⬇️  Downloaded page ${page + 1} with ${res.response.checkins.items.length} items.`)
    items.push(...res.response.checkins.items)
  }

  await fs.outputJSON(historyFile, items, {
    spaces: 2
  })

  for (const item of items) {
    const filePath = path.join(singleDir, `${item.id}.json`)
    if (await fs.existsSync(filePath)) {
      continue
    }

    const data = await getID(item.id, accessToken)
    console.log(`📌 Got full data for ${item.id}.`)
    await fs.outputJSON(filePath, data, {
      spaces: 2
    })
  }

  console.log(`✅ ${items.length} items downloaded.`)
}
