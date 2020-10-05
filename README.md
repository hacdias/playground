# Silos Collectors

This is a compilation of some silos data collectors I use for my strictly personal use. Feel free to reuse code and use it for your own purposes.

## GoodReads

> Collects [GoodReads](https://goodreads.com) history.

1. Create an application on https://goodreads.com/api
2. Fill the variables
3. Run `./bin.js goodreads sync` and your GitHub will be updated.

## Swarm

> Collects [Swarm](https://www.swarmapp.com/) history.

1. Create an application on https://foursquare.com/developers/apps/.
    - The callback should be `http://localhost:PORT/callback` where `PORT` is defined on `.env`.
2. Run `./bin.js swarm login` and append the result to `.env`.
3. Run `./bin.js swarm sync` and then a file called `history.json` will be generated.

## Trakt

> Collects [Trakt](https://trakt.tv) history.

1. Create an application on https://trakt.tv/oauth/applications/new.
    - The callback should be `http://localhost:PORT/callback` where `PORT` is defined on `.env`.
2. Fill the `TRAKT_DATA_DIR` where the history will be dumped. The directory **must** exist.
3. Run `./bin.js trakt login` and append the result to `.env`.
4. Run `./bin.js trakt sync` and then a file called `history.json` will be generated.

## Miniflux

To write...

## LastFM

To write...

## Known Issues

- This **does not** deal with token refreshes so it won't be able to refresh the token.
