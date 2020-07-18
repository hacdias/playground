const login = require('../login')

module.exports = () => login({
  port: process.env.PORT,
  config: {
    client: {
      id: process.env.TRAKT_ID,
      secret: process.env.TRAKT_SECRET
    },
    auth: {
      tokenHost: 'https://trakt.tv/oauth'
    }
  }
})
