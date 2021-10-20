const { sync } = require('@testground/sdk')

const Libp2p = require('libp2p')
const TCP = require('libp2p-tcp')
const Mplex = require('libp2p-mplex')
const { NOISE } = require('@chainsafe/libp2p-noise')
const KadDHT = require('libp2p-kad-dht')

const createNode = async () => {
  const node = await Libp2p.create({
    addresses: {
      listen: ['/ip4/0.0.0.0/tcp/0']
    },
    modules: {
      transport: [TCP],
      streamMuxer: [Mplex],
      connEncryption: [NOISE],
      dht: KadDHT
    },
    config: {
      dht: {
        enabled: true
      }
    }
  })

  await node.start()
  return node
}

// TODO: maybe this is a nice utility to export
// from @testground/sdk, as in sync.withClient
const withClient = fn => async (runenv) => {
  const client = await sync.newBoundClient(runenv)

  try {
    await fn(runenv, client)
  } finally {
    client.close()
  }
}

module.exports = withClient(async (runenv, client) => {
  let node

  try {
    node = await createNode()

    runenv.recordMessage(`I am ${node.peerId.toString()}`)
  } finally {
    if (node) await node.stop()
  }
})
