const got = require('got')
const updateGitHub = require('../update-github')

const user = process.env.FEEDBIN_USER
const password = process.env.FEEDBIN_PASSWORD
const githubRepo = process.env.FEEDBIN_GITHUB_REPO
const githubPath = process.env.FEEDBIN_GITHUB_PATH

const feedbin = got.extend({
  prefixUrl: 'https://api.feedbin.com',
  headers: {
    Authorization: 'Basic ' + Buffer.from(`${user}:${password}`).toString('base64')
  },
  responseType: 'json'
})

async function getTaggings () {
  const { body } = await feedbin('v2/taggings.json')
  return body
}

async function getSubscriptions () {
  const { body } = await feedbin('v2/subscriptions.json?mode=extende')
  return body
}

module.exports = async () => {
  const subs = await getSubscriptions()
  const subsById = subs.reduce((acc, curr) => {
    acc[curr.feed_id] = curr
    return acc
  }, {})
  const tags = await getTaggings()
  const blogroll = {}

  for (let { feed_id, name } of tags) {
    name = name.toLowerCase()
    if (name !== 'following' && name !== 'comics') continue

    blogroll[name] = blogroll[name] || []
    blogroll[name].push({
      feed: subsById[feed_id].feed_url,
      site: subsById[feed_id].site_url,
      title: subsById[feed_id].title
    })
  }

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
