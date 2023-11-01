{
	"title": "Comparing Emerging Distributed File Sharing Protocols",
	"mermaid": false,
	"math": false,
	"backlinks": []
}

## What

Compare emerging distributed file sharing protocols, such as IPFS (uses BitSwap[^1]), BitTorrent, DAT, Secure Scuttlebutt (more?)

## What

- Compare fetch times (not discovery!) on same network conditions:
  - Latency
  - Bandwidth Speed
- 1 node serves the file, all other nodes try to fetch
- Test matrix between:
  - Nodes amount:
    - 10
    - 100
    - 1000
    - 10000
  - File size
    - 1 MB
    - 10 MB
    - 100 MB
    - 1 GB
  - File content
    - Completely random
    - Non-random with repetitions that makes deduplication possible

## How

Use Testground project to write the tests.

## Methodology

- IPFS
  - File host
    - Add file to IPFS --> Get CID
    - Send CID to all other nodes
  - Connect all nodes between themselves (ipfs swarm connect)
  - All nodes but the file host 'ipfs get' --> Time
- BitTorrent
  - File host
    - Add file, create torrent --> Get magnet
  - Other nodes
    - Add file host as tracker
  - All nodes but the file host fetch torrent & wait
- DAT
- SSB

## Why

- Try to understand which network is faster to retrieve content.
- Understand why is it faster compared to other networks.
- Opportunity to learn a lot more about the protocols used in this case, as well as their implementation specifics

## To Read / Summarize

- IPFS Whitepaper
- DAT Whitepaper
- BitTorrent paper

[^1]: https://github.com/ipfs/go-bitswap/blob/master/docs/how-bitswap-works.md