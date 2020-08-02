{
	"title": "Distributed Hash Table",
	"mermaid": false,
	"math": true,
	"backlinks": [
		{
			"Target": "/bittorrent",
			"Before": "Unknown",
			"Actual": "Distributed Hash Table",
			"After": "Unknown"
		},
		{
			"Target": "/chord-dht",
			"Before": "Unknown",
			"Actual": "Distributed Hash Table",
			"After": "Unknown"
		},
		{
			"Target": "/ipfs",
			"Before": "Unknown",
			"Actual": "Distributed Hash Table",
			"After": "Unknown"
		},
		{
			"Target": "/kademlia-dht",
			"Before": "Unknown",
			"Actual": "Distributed Hash Table",
			"After": "Unknown"
		},
		{
			"Target": "/peer-to-peer-systems-and-applications",
			"Before": "Unknown",
			"Actual": "Distributed Hash Table",
			"After": "Unknown"
		}
	]
}

- **tags**: [Distributed Systems](/distributed-systems/)

DHTs are Distributed Hash Tables which are P2P algorithms.

>  "A system where the nodes organize themselves in a structured overlay and establish a small amount of routing information for quick and efficient routing to other overlay nodes." - [Peer-to-Peer Systems and Applications](/peer-to-peer-systems-and-applications/)

- P2P Algorithms: different implementations
- Nodes store index info about other resources
- Flat architecture: no special nodes
- Usually can find resources on $O(\log N)$
- By distributing identifiers of nodes and data equally thorough the system, the load shoud be balanced across all peers
	- PROBLEM: obviously there are some resources that are always more accessed than others, creating possibily huge differences.
- Data storage:
	- **Direct storage**: data is copied upon insertion to the responsible node.
		- Good because the data is directly on the peer.
		- Bad for bandwidth and resources.
	- **Referenced storage**: references pointers to the actual location of the data.
		- Good because there's less load on the DHT.
		- Bad becauser data is only available while the node is available.

## Algorithms

- [Chord (DHT)](/chord-dht/)
- [Content Addressable Network (DHT)](/content-addressable-network-dht/)
- [Tapestry (DHT)](/tapestry-dht/)
- [Pastry (DHT)](/pastry-dht/)
- [Kademlia (DHT)](/kademlia-dht/)
