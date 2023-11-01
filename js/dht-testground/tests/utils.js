const { sync, network } = require('@testground/sdk')
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

const bureaucracy = fn => async (runenv) => {
  const client = await sync.newBoundClient(runenv)

  try {
    const netclient = network.newClient(client, runenv)
    runenv.recordMessage('waiting for network initialization')

    netclient.waitNetworkInitialized()
    runenv.recordMessage('network initilization complete')

    await fn(runenv, client, netclient)
  } finally {
    client.close()
  }
}

module.exports = {
  bureaucracy,
  createNode
}
