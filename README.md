
# DHT Testground Example

The example test `peer-routing` connects an even number of nodes in a circle and then tries to reach the node in the opposite side of the circle.

First import plan to testground:

```
testground plan import --from dht-testground
```

Then run it:

```
testground run s -r local:docker -b docker:node -p dht-testground -t peer-routing -i 12 --wait
```
