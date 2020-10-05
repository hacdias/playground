const fs = require('fs-extra')
const path = require('path')

module.exports = async () => {
  const dataDir = path.join(process.env.DATA_DIR, 'swarm')
  const data = await fs.readJSON(path.join(dataDir, 'history.json'))

  const ids = []

  const countries = data.reduce((acc, curr) => {
    acc[curr.venue.location.country] = acc[curr.venue.location.country] || 0

    if (!ids.includes(curr.venue.id)) {
      acc[curr.venue.location.country]++
      ids.push(curr.venue.id)
    }
    return acc
  }, {})

  const values = []

  for (const key in countries) {
    values.push({
      category: key,
      amount: countries[key]
    })
  }

  console.log(JSON.stringify(values, null, 2))
}
