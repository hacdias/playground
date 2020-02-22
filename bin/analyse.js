#!/usr/bin/env node

require('dotenv').config()

const vega = require('vega')
const vegaLite = require('vega-lite')

const fs = require('fs-extra')
const { join } = require('path')

const monthNames = [
  'January', 'February', 'March', 'April', 'May', 'June',
  'July', 'August', 'September', 'October', 'November', 'December'
]

// svgo *.svg --multipass --disable=removeViewBox --enable=removeDimensions

;(async () => {
  const rawDir = join(process.env.DATA_DIR, 'raw')
  const outputDir = join(process.env.DATA_DIR, 'output')
  const historyFile = join(rawDir, 'history.json')

  const history = (await fs.readJSON(historyFile))
    .filter(e => new Date(e.watched_at).getFullYear() === 2019)
    // .filter(({ type }) => type === 'movie')
    // .filter(({ type }) => type === 'episode')

  await output(weekdayDistribution(history), join(outputDir, 'weekday.svg'))
  await output(yearDistribution(history), join(outputDir, 'year-dist.svg'))
  await output(genresAnalyse(history), join(outputDir, 'genres-general.svg'))
  await output(perMonth(history), join(outputDir, 'monthly.svg'))
})()

function perMonth (history) {
  const data = Object.values(history.reduce((acc, curr) => {
    const date = new Date(curr.watched_at)
    const month = date.getMonth()

    acc[month] = acc[month] || {
      monthN: month,
      month: monthNames[month].substr(0, 3),
      movies: 0,
      episodes: 0
    }

    if (curr.type === 'movie') {
      acc[month].movies++
    } else {
      acc[month].episodes++
    }

    return acc
  }, {}))
    .reduce((acc, curr) => {
      acc.push({
        month: curr.month,
        Type: 'M',
        sum: curr.movies
      })

      acc.push({
        month: curr.month,
        Type: 'E',
        sum: curr.episodes
      })

      return acc
    }, [])

  return {
    data: { values: data },
    width: { step: 12 },
    mark: 'bar',
    title: {
      text: '2019 Watches per Month',
      anchor: 'middle'
    },
    encoding: {
      column: {
        field: 'month',
        type: 'ordinal',
        axis: {
          title: null
        },
        spacing: 10,
        sort: monthNames
      },
      y: {
        aggregate: 'sum',
        field: 'sum',
        type: 'quantitative',
        axis: { title: 'Watches', grid: false }
      },
      x: {
        field: 'Type',
        type: 'nominal',
        axis: { title: '' }
      },
      color: {
        field: 'Type',
        type: 'nominal',
        scale: { range: ['#fed330', '#3867d6'] }
      }
    },
    config: {
      view: { stroke: 'transparent' },
      axis: { domainWidth: 1 }
    }
  }
}

function capitalizeFirstLetter (string) {
  return string.charAt(0).toUpperCase() + string.slice(1)
}

function genresAnalyse (history) {
  const testedShows = []

  const data = Object.entries(history.reduce((acc, curr) => {
    const genres = curr.type === 'movie'
      ? curr.movie.genres
      : curr.show.genres

    if (curr.type === 'episode' && testedShows.includes(curr.show.ids.slug)) {
      return acc
    }

    if (curr.type === 'episode') {
      testedShows.push(curr.show.ids.slug)
    }

    for (const genre of genres) {
      acc[genre] = acc[genre] || {
        movies: 0,
        shows: 0
      }

      if (curr.type === 'movie') {
        acc[genre].movies++
      } else {
        acc[genre].shows++
      }
    }

    return acc
  }, {})).map(([key, value]) => ({
    name: capitalizeFirstLetter(key.replace('-', ' ')),
    total: value.shows + value.movies,
    ...value
  }))

  return {
    title: {
      text: '2019 Most Watched Genres'
    },
    data: { values: data },
    mark: 'bar',
    encoding: {
      y: {
        field: 'name',
        type: 'nominal',
        axis: { title: null },
        sort: {
          field: 'total',
          order: 'descending'
        }
      }
    },
    layer: [{
      mark: { type: 'bar', color: '#3867d6' },
      encoding: {
        x: {
          field: 'total',
          type: 'quantitative',
          axis: {
            title: 'Watches (shows, movies)'
          }
        }
      }
    }, {
      mark: { type: 'bar', color: '#fed330' },
      encoding: {
        x: { field: 'shows', type: 'quantitative' }
      }
    }]
  }
}

function yearDistribution (history) {
  const data = history.reduce((acc, curr) => {
    const date = new Date(curr.watched_at)
    const month = date.getMonth()
    const day = date.getDate()

    acc[month] = acc[month] || {}
    acc[month][day] = acc[month][day] || 0
    acc[month][day]++

    return acc
  }, {})

  const views = []

  for (let i = 0; i < 12; i++) {
    for (let j = 1; j <= 31; j++) {
      if (data[i] && data[i][j]) {
        views.push({ month: monthNames[i], day: j, views: data[i][j] })
      }
    }
  }

  return {
    title: '2019 TV Series and Movies Views',
    data: { values: views },
    config: {
      view: {
        strokeWidth: 0,
        step: 20
      },
      axis: {
        domain: false
      },
      range: {
        heatmap: ['#fed330', '#3867d6']
      }
    },
    mark: 'rect',
    encoding: {
      x: {
        field: 'day',
        type: 'ordinal',
        title: 'Day'
      },
      y: {
        field: 'month',
        type: 'ordinal',
        title: 'Month'
      },
      color: {
        field: 'views',
        aggregate: 'max',
        type: 'quantitative',
        legend: {
          title: null
        }
      }
    }
  }
}

const weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']

function weekdayDistribution (history) {
  const data = Object.entries(history.reduce((acc, curr) => {
    const date = new Date(curr.watched_at)
    const weekday = date.getDay()
    acc[weekday] = acc[weekday] || { movies: 0, episodes: 0, total: 0 }
    acc[weekday].total++

    if (curr.type === 'movie') {
      acc[weekday].movies++
    } else {
      acc[weekday].episodes++
    }

    return acc
  }, {})).map(([weekday, { total, movies, episodes }]) => ({ weekday: weekdays[weekday], total, movies, episodes }))

  return {
    title: '2019 Weekday Distribution',
    data: { values: data },
    mark: 'bar',
    encoding: {
      y: { field: 'weekday', type: 'nominal', axis: { title: null } }
    },
    layer: [
      {
        mark: { type: 'bar', color: '#eb3b5a' },
        encoding: {
          x: {
            field: 'total',
            type: 'quantitative',
            axis: {
              title: 'Movie, Episodes'
            }
          }
        }
      },
      {
        mark: { type: 'bar', color: '#fd9644' },
        encoding: {
          x: { field: 'movies', type: 'quantitative' }
        }
      }]
  }
}

async function output (spec, path) {
  const view = new vega.View(vega.parse(vegaLite.compile(spec).spec, null), {
    renderer: 'none'
  }).finalize()

  fs.outputFileSync(path, await view.toSVG(1))
}
