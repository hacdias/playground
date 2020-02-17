require('dotenv').config()

const opn = require('opn')
const express = require('express')

const CREDENTIALS = {
  client: {
    id: process.env.TRAKT_ID,
    secret: process.env.TRAKT_SECRET
  },
  auth: {
    tokenHost: 'https://trakt.tv/oauth'
  }
}

const CALLBACK = `http://localhost:${process.env.PORT}/callback`

;(async () => {
  const oauth2 = require('simple-oauth2').create(CREDENTIALS)
  const authorizationUri = oauth2.authorizationCode.authorizeURL({ redirect_uri: CALLBACK })

  opn(authorizationUri)

  const app = express()

  app.get('/callback', async function (req, res) {
    const tokenConfig = {
      code: req.query.code,
      redirect_uri: CALLBACK
    }

    let code = 0

    try {
      const result = await oauth2.authorizationCode.getToken(tokenConfig)
      const accessToken = oauth2.accessToken.create(result)

      console.log(`ACCESS_TOKEN=${accessToken.token.access_token}`)
    } catch (error) {
      code = 1
      console.log('Could not get access token:', error.message)
    }

    res.set('Content-Type', 'text/html')
    res.send(Buffer.from('<script>window.close();</script>'))
    server.close()
    process.exit(code)
  })

  const server = app.listen(process.env.PORT)
})()
