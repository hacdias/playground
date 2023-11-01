const { invokeMap } = require('@testground/sdk')

const testCases = {
  'peer-routing': require('./tests/peer-routing'),
  'content-routing': require('./tests/content-routing')
}

;(async () => {
  // This is the plan entry point.
  await invokeMap(testCases)
})()
