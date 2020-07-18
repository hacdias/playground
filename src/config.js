require('dotenv').config()

module.exports = {
  port: process.env.PORT,
  github: {
    username: process.env.GITHUB_USERNAME,
    token: process.env.GITHUB_TOKEN
  },
  goodreads: {
    user: process.env.GOODREADS_USER,
    apiId: process.env.GOODREADS_API_ID,
    githubRepo: process.env.GOODREADS_GITHUB_REPO,
    githubPath: process.env.GOODREADS_GITHUB_PATH
  },
  foursquare: {
    id: process.env.FOURSQUARE_ID,
    secret: process.env.FOURSQUARE_SECRET,
    accessToken: process.env.FOURSQUARE_ACCESS_TOKEN,
    dataDir: process.env.FOURSQUARE_DATA_DIR
  },
  trakt: {
    id: process.env.TRAKT_ID,
    secret: process.env.TRAKT_SECRET,
    accessToken: process.env.TRAKT_ACCESS_TOKEN,
    githubRepo: process.env.TRAKT_GITHUB_REPO,
    githubPath: process.env.TRAKT_GITHUB_PATH,
    dataDir: process.env.TRAKT_DATA_DIR
  },
  tmdb3Key: process.env.TMDB_V3_KEY
}
