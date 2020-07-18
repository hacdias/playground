const got = require('got')
const path = require('path')
const fs = require('fs-extra')
const updateGitHub = require('../update-github')

const dataDir = path.join(process.env.DATA_DIR, 'lastfm')
const apiKey = process.env.LASTFM_KEY
const user = process.env.LASTFM_USER
const githubRepo = process.env.LASTFM_GITHUB_REPO
const githubPath = process.env.LASTFM_GITHUB_PATH

async function get (page) {
  const { body } = await got(`https://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user=${user}&api_key=${apiKey}&format=json&limit=200&page=${page}`, {
    responseType: 'json'
  })

  const totalPages = body.recenttracks['@attr'].totalPages
  return { body: body.recenttracks.track, totalPages }
}

async function getTopArtists () {
  const { body } = await got(`https://ws.audioscrobbler.com/2.0/?method=user.gettopartists&user=${user}&api_key=${apiKey}&format=json&limit=10&period=7day`, {
    responseType: 'json'
  })

  return body.topartists.artist.map(artist => ({
    name: artist.name,
    count: Number.parseInt(artist.playcount),
    url: artist.url
  }))
}

async function getTopTracks () {
  const { body } = await got(`https://ws.audioscrobbler.com/2.0/?method=user.gettoptracks&user=${user}&api_key=${apiKey}&format=json&limit=10&period=7day`, {
    responseType: 'json'
  })

  return body.toptracks.track.map(track => ({
    name: track.name,
    url: track.url,
    count: Number.parseInt(track.playcount),
    artist: track.artist.name
  }))
}

module.exports = async () => {
  const items = []

  for (let page = 1, res; (res = await get(page)) && res.totalPages >= page; page++) {
    const its = res.body.filter(item => !item['@attr'] || item['@attr']['nowplaying'] !== 'true')
    console.log(`⬇️  Page ${page} downloaded with ${its.length} items.`)
    items.push(...its)
  }

  console.log(`✅ ${items.length} items downloaded.`)
  await fs.outputJSON(path.join(dataDir, 'history.json'), items, { spaces: 2 })

  console.log('🎶 Fetching top artists and tracks from last week')

  const lastWeek = {
    artists: await getTopArtists(),
    tracks: await getTopTracks()
  }

  await fs.outputJSON(path.join(dataDir, 'week.json'), lastWeek, { spaces: 2 })

  await updateGitHub({
    data:  JSON.stringify(lastWeek, null, 2),
    repo: githubRepo,
    path: githubPath,
    message: `${new Date().toUTCString()} update music`
  })

}