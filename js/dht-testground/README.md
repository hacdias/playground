
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


## Content Routing Example

First, import the plan as mentioned above. Then, you can run it:

```
testground run s \
  -r local:docker \
  -b docker:node \
  -p dht-testground \
  -t content-routing -i 6 \
  --wait --collect
```

You may replace 6 but any number of instances you want. In the end, you should have the output with the run ID. A file `[run-id].tgz` will be generated with the logs. Extract it:

```
tar -xvf [run-id].tgz
```

Then process it:

```
node process-logs.js [run-id]
```
