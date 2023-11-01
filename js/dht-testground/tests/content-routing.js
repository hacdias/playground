const { performance } = require('perf_hooks')
const delay = require('delay')
const PeerId = require('peer-id')
const { Multiaddr } = require('multiaddr')
const { bureaucracy, createNode } = require('./utils')
const { CID } = require('multiformats/cid')

module.exports = bureaucracy(async (runenv, client, netclient) => {
  let node

  const states = {
    enrolled: 'enrolled',
    nodeCreated: 'nodeCreated',
    bootstrap: 'bootstrap',
    connected: 'connected',
    published: 'published',
    done: 'done'
  }

  try {
    // Signal entry to the enrolled state, and obtain a sequence number.
    // We will use this number to know where in the "circle" we are.
    const seq = await client.signalEntry(states.enrolled)
    node = await createNode()

    runenv.recordMessage({
      event: 'node-created',
      ts: performance.now(),
      peerId: node.peerId.toString()
    })

    // Wait for all the nodes to be created.
    await client.signalAndWait(states.nodeCreated, runenv.testInstanceCount)

    if (seq === 1) {
      // Bootstrap node: publishes the peerId and multiaddresses.

      await client.publish(states.bootstrap, {
        peerId: node.peerId.toString(),
        multiaddrs: node.multiaddrs.map(ma => ma.toString())
      })
    } else {
      // Other nodes: wait for the bootstrap peerId and multiaddresses and connect.

      const sub = await client.subscribe(states.bootstrap)

      const bootstrapNode = await sub.wait.next()
      sub.cancel()

      let { peerId, multiaddrs } = bootstrapNode.value
      peerId = PeerId.parse(peerId)
      multiaddrs = multiaddrs.map(ma => new Multiaddr(ma))

      runenv.recordMessage({
        event: 'received-bootstrap',
        ts: performance.now(),
        peerId: peerId.toString()
      })

      if (seq !== 2) {
        // Connect to the bootstrap node.
        node.peerStore.addressBook.set(peerId, multiaddrs)
        await node.dial(peerId)

        runenv.recordMessage({
          event: 'dialed-bootstrap',
          ts: performance.now(),
          peerId: peerId.toString()
        })

        // The DHT routing tables need a moment to populate
        await delay(100)

        // Wait for all peers to have dialed the bootstrap node.
        await client.signalAndWait(states.connected, runenv.testInstanceCount - 2)
      }

      const cid = CID.parse('QmTp9VkYvnHyrqKQuFPiuZkiX9gPcqj6x5LJ1rmWuSySnL')

      if (seq === 2) {
        // Join the network later and find the content.
        const b = await client.barrier(states.published, 1)
        await b.wait

        // Connect to the bootstrap node.
        node.peerStore.addressBook.set(peerId, multiaddrs)
        await node.dial(peerId)

        runenv.recordMessage({
          event: 'dialed-bootstrap',
          ts: performance.now(),
          peerId: peerId.toString()
        })

        // The DHT routing tables need a moment to populate
        await delay(100)

        runenv.recordMessage({
          event: 'find-content',
          ts: performance.now(),
          cid: cid.toString()
        })

        const start = performance.now()
        for await (const provider of node.contentRouting.findProviders(cid, { timeout: 3000 })) {
          runenv.recordMessage(`found provider: ${provider.id.toString()}`)
        }
        const end = performance.now()

        runenv.recordMessage({
          event: 'found-content',
          ts: performance.now(),
          cid: cid.toString(),
          took: end - start
        })
      } else if (seq === 3) {
        // Provide the content.
        await node.contentRouting.provide(cid)
        runenv.recordMessage({
          event: 'providing-content',
          ts: performance.now(),
          cid: cid.toString()
        })
        // Wait for propagation.
        await delay(5000)
        await client.signalEntry(states.published)
      }
    }

    // Wait for all the nodes before exiting.
    await client.signalAndWait(states.done, runenv.testInstanceCount)
  } finally {
    // TODO: node hangs while stopping. Adding a delay reduces the likeliness.
    await delay(1000)
    runenv.recordMessage({ event: 'node-stopping', ts: performance.now() })
    if (node) await node.stop()
    runenv.recordMessage({ event: 'node-stopped', ts: performance.now() })
  }
})
