# GoodReads Collector

These are just some scripts to collect your [GoodReads](https://goodreads.com) history.

## To collect your history

1. Copy `.env.example` to `.env`
2. Create an application on https://goodreads.com/api
3. Fill the variables
4. Run `node sync.js` and your GitHub will be updated.

# Swarm Collector

These are just some scripts to collect your [Swarm](https://www.swarmapp.com/) history. I'm using this for personal uses.

## To collect your history

1. Copy `.env.example` to `.env` and fill the blanks.
2. Create an application on https://foursquare.com/developers/apps/.
    - The callback should be `http://localhost:PORT/callback` where `PORT` is defined on `.env`.
3. Run `node bin/login` and append the result to `.env`.
4. Run `node bin/sync and then a file called `history.json` will be generated.

# Trakt Collector

These are just some scripts to collect your [Trakt](https://trakt.tv) history.

## To collect your history

1. Copy `.env.example` to `.env`
2. Create an application on https://trakt.tv/oauth/applications/new.
    - The callback should be `http://localhost:PORT/callback` where `PORT` is defined on `.env`.
3. Fill the `OUTPUT_DIRECTORY` where the history will be dumped. The directory **must** exist.
4. Run `node bin/login` and append the result to `.env`.
5. Run `node bin/sync` and then a file called `history.json` will be generated.

## Known Issues

- This **does not** deal with token refreshes so it won't be able to refresh the token.
