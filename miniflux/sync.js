const got = require('got')
const updateGitHub = require('../update-github')

const entrypoint = process.env.MINIFLUX_ENTRYPOINT
const user = process.env.MINIFLUX_USER
const password = process.env.MINIFLUX_PASSWORD
const githubRepo = process.env.MINIFLUX_GITHUB_REPO
const githubPath = process.env.MINIFLUX_GITHUB_PATH

async function fetch () {
  const { body } = await got(entrypoint + '/v1/feeds', {
    headers: {
      Authorization: 'Basic ' + Buffer.from(`${user}:${password}`).toString('base64')
    },
    responseType: 'json'
  })
  return body
}

module.exports = async () => {
  const subs = await fetch()

  const blogroll = subs.reduce((acc, curr) => {
    const category = curr.category.title.toLowerCase()
    if (category !== 'following' && category !== 'comics') {
      return acc
    }

    acc[category] = acc[category] || []
    acc[category].push({
      feed: curr.feed_url,
      site: curr.site_url,
      title: curr.title
    })

    return acc
  }, {})

  for (const key in blogroll) {
    blogroll[key].sort((a, b) => {
      var tA = a.title.toUpperCase()
      var tB = b.title.toUpperCase()
      if (tA < tB) {
        return -1
      }
      if (tA > tB) {
        return 1
      }
      return 0
    })
  }

  await updateGitHub({
    data: JSON.stringify(blogroll, null, 2),
    repo: githubRepo,
    path: githubPath,
    message: `${new Date().toUTCString()} update blogroll`
  })
}
