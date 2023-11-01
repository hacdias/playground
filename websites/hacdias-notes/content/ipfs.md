{
	"title": "IPFS",
	"mermaid": false,
	"math": false,
	"backlinks": [
		{
			"Target": "/filecoin",
			"Before": "Unknown",
			"Actual": "IPFS",
			"After": "Unknown"
		},
		{
			"Target": "/ipfs-whitepaper-draft-3",
			"Before": "Unknown",
			"Actual": "IPFS",
			"After": "Unknown"
		},
		{
			"Target": "/kademlia-dht",
			"Before": "Unknown",
			"Actual": "IPFS",
			"After": "Unknown"
		},
		{
			"Target": "/naming-system",
			"Before": "Unknown",
			"Actual": "IPFS",
			"After": "Unknown"
		}
	]
}

- **specs**: https://github.com/ipfs/specs

IPFS is a [P2P](/p2p/) [Protocol](/protocol/)

## Stack

- [IPLD](/ipld/)
- [BitSwap](/bitswap/)
- [Distributed Hash Table](/distributed-hash-table/)

### The DHT

Read more at https://blog.ipfs.io/2020-07-20-dht-deep-dive/.

- IPFS uses a custom version of [Kademlia (DHT)](/kademlia-dht/).
	- **Address space**: `0` to `2^256-1`
	- **Metric**: `SHA256(PeerID)` --> `0` to `2^256-1`
	- **Projection**: `SHA256(RecordKey)`
- The DHT stores 3 types of key-value pairings:
	- Provider Records: map identifiers (i.e., multihashes) to peers that adversited they have and are willing to provide the content.
		- Used by IPFS to find content
		- Used by IPNS over PubSub to find other members of the pubsub topic
	- IPNS Records: map IPNS keys to IPNS records
		- Used by IPNS
	- Peer Records: map peerID to a set of multiaddresses at which the peer may be reached
		- Used by IPFS when we know of a peer wwith content, but don't know its address
		- Used for manual connectiong (ipfs swarm connect...)
	- **KEEP READING:** https://blog.ipfs.io/2020-07-20-dht-deep-dive/#kademlia-and-undialable-peers

## Compared to [BitTorrent](/bittorrent/)

- Does not privilege nodes.
- Blocks are not tied to a specific torrent.

## Compared to [DAT](/dat/)

- TODO

