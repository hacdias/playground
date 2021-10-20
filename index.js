const { invokeMap } = require('@testground/sdk')

const testCases = {
  connect: require('./connect')
}

;(async () => {
  // This is the plan entry point.
  await invokeMap(testCases)
})()
