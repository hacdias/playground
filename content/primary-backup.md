{
	"title": "Primary-backup",
	"mermaid": false,
	"math": true,
	"backlinks": [
		{
			"Target": "/replication",
			"Before": "Unknown",
			"Actual": "Primary-backup",
			"After": "Unknown"
		}
	]
}

Some **assumptions**:

- [Passive replication](/replication/#active-vs-passive)
- [Fail-silent faults](/fault-tolerance/)
- Atomic operations
- Total replication
- Static amount of replicas and known beforehand.
- $f+1$ replicas tolerate $f$ faults

![Passive Replication](attachments/passive-replication.png)

1. Client sends request to the primary server using the [*at most once*](/remote-procedure-call/#server-failure) semantics.
2. Primary server handles all request by causal order.
   1. If there is a duplicated request, return saved response.
3. Executes request and saves reply.
4. Primary sends to the secondary servers the new state, reply and request id. Secondary servers should ACK.
5. Primary replies to client.

TODO