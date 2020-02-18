# Swarm Collector

These are just some scripts to collect your [Swarm](https://www.swarmapp.com/) history. I'm using this for personal uses.

## To collect your history

1. Copy `.env.example` to `.env`
2. Create an application on https://foursquare.com/developers/apps/.
    - The callback should be `http://localhost:PORT/callback` where `PORT` is defined on `.env`.
3. Run `node login.js` and append the result to `.env`.
4. Run `node collect.js` and then a file called `history.json` will be generated.
