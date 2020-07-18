/*

GET POSTERS (?)

const got = require('got')
const fs = require('fs-extra')
const { join } = require('path')
const stream = require('stream')
const { promisify } = require('util')
const pipeline = promisify(stream.pipeline)

const API_KEY = process.env.TMDB_V3_KEY

async function getMovie (path, output) {
  const { body } = await got(`https://api.themoviedb.org/3/${path}?api_key=${API_KEY}`, { responseType: 'json' })
  const poster = `https://image.tmdb.org/t/p/original${body.poster_path}`

  await pipeline(
    got.stream(poster),
    fs.createWriteStream(output)
  )
}

;(async () => {
  const postersDir = join(process.env.TRAKT_DATA_DIR, 'posters')
  const rawDir = join(process.env.TRAKT_DATA_DIR, 'raw')
  const historyFile = join(rawDir, 'history.json')
  const history = await fs.readJSON(historyFile)

  const movies = history.filter(({ type }) => type === 'movie')

  await fs.ensureDir(join(postersDir, 'movies'))
  await fs.ensureDir(join(postersDir, 'shows'))

  for (const item of movies) {
    const posterPath = join(postersDir, 'movies', item.movie.ids.slug + '.jpg')
    if (await fs.exists(posterPath)) {
      continue
    }

    await getMovie(
      `movie/${item.movie.ids.tmdb}`,
      join(postersDir, 'movies', item.movie.ids.slug + '.jpg')
    )
  }

  // TODO: series
})()

*/