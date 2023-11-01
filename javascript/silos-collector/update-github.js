const got = require('got')

const github = got.extend({
  prefixUrl: 'https://api.github.com',
  username: process.env.GITHUB_USERNAME,
  password: process.env.GITHUB_TOKEN,
  responseType: 'json'
})

module.exports = async function updateGitHub ({ data, repo, path, message }) {
  const encoded = Buffer.from(data).toString('base64')
  const githubPath = `repos/${repo}/contents/${path}`

  console.log('🖥  Fetching from GitHub...')
  const get = await github(githubPath)
  const oldData = get.body.content.split('\n').join('').trim()

  if (oldData === encoded) {
    console.log('✅ Already up to date!')
    return
  }

  await github.put(githubPath, {
    json: {
      message: message,
      content: encoded,
      sha: get.body.sha
    }
  })

  console.log('✅ Commit created!')
}
