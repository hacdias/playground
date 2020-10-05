const express = require('express')
const open = require('open')
const { AuthorizationCode } = require('simple-oauth2')

module.exports = async function ({ port, config }) {
  const redirect = `http://localhost:${port}/redirect`
  const callback = `http://localhost:${port}/callback`

  console.log('⚙️  Generating an authorization URL')

  const client = new AuthorizationCode(config)
  const authorizationUri = client.authorizeURL({
    redirect_uri: callback
  })
  console.log(`🔗 Open the authorization URL: ${authorizationUri}`)

  const app = express()

  app.get('/redirect', async function (req, res) {
    res.redirect(authorizationUri)
  })

  app.get('/callback', async function (req, res) {
    const tokenParams = {
      code: req.query.code,
      redirect_uri: callback
    }

    let code = 0

    try {
      const accessToken = await client.getToken(tokenParams);
      console.log('✅ Access Token is:')
      console.log(accessToken.token)
    } catch (error) {
      code = 1
      console.log('❌ Could not get access token:', error.message)
    }

    res.set('Content-Type', 'text/html')
    res.send(Buffer.from('<!DOCTYPE html><html><head></head><body><h1>Please close this page and go back to the CLI.</h1><script>window.close();</script></body></html>'))
    server.close()
    process.exit(code)
  })

  const server = app.listen(port)
  await open(redirect)
}
