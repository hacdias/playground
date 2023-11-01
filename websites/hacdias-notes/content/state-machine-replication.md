{
	"title": "State Machine Replication",
	"mermaid": false,
	"math": false,
	"backlinks": [
		{
			"Target": "/replication",
			"Before": "Unknown",
			"Actual": "State Machine Replication",
			"After": "Unknown"
		}
	]
}

**State Machine Replication** is a [Replication](/replication/) technique that allows for strong consistency and high availability (C+A), hence it does not tolerate net partitions.

- It's a **generic** solution for [Fault Tolerant](/fault-tolerance/) services.
- Each server is a state machine defined by state variables.
- The operations are atomic.

Every server is required to have the same initial state and agreement (interface), to execute the operations by the same order and to have deterministic operations.

There are many algorithms that implement this technique:

- Fail-silent Faults
  - Paxos
  - [RAFT](/raft/)
- Byzantine Faults
  - PBFT
