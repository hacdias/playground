# Trakt Collector

These are just some scripts to collect your [Trakt](https://trakt.tv) history.

## To collect your history

1. Copy `.env.example` to `.env`
2. Create an application on https://trakt.tv/oauth/applications/new.
    - The callback should be `http://localhost:PORT/callback` where `PORT` is defined on `.env`.
3. Run `node login.js` and append the result to `.env`.
4. Run `node collect.js` and then a file called `history.json` will be generated.


