package main

const templateString = `<!doctype html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Journal</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.1.1/normalize.min.css">

    <style>
    * {
        box-sizing: border-box;
    }
    a {
        color: inherit;
        text-decoration: none;
    }
    body {
        font-family: 'Roboto Mono', monospace;
        padding: 0;
        margin: 0;
        color: #212121;
    }
    .container {
        margin: 0 auto;
        width: 90%;
        max-width: 600px;
    }
    h1 {
        text-align: center;
    }
    nav {
        border-bottom: 1px dashed #212121;
        padding: 1em 0;
    }
    nav .container {
        display: flex;
    }
    nav a, nav .container> div {
        flex-basis: 50%;
        color: #212121;
        font-weight: bold;
    }
    nav .container> div {
        text-align: right;
    }
    input,
    textarea {
        width: 100%;
        font-size: 1em;
        border: 1px dashed #212121;
        padding: .2em;
        border-bottom: 0;
    }
    textarea {
        min-height: 32em;
        resize: vertical;
    }
    textarea:active {
        outline: 0;
        border-color: #000;
    }
    button {
        padding: .2em .5em;
        font-size: 1em;
        border: 1px dashed #212121;
        background-color: #fff;
        font-family: inherit;
        cursor: pointer;
        transition: .1s ease all;
        width: 100%;
    }
    button:hover, button:active {
        outline: 0;
        background-color: #212121;
        border: 1px dashed #fff;
        color: #fff;
    }
    textarea, input, button {
        margin: 0;
        display: block;
    }
    ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    li:first-of-type {
        border-top: 1px dashed #212121;
    }
    li {
        border-bottom: 1px dashed #212121;
        padding: .5em 0;
    }
    .tags {
        text-align: right;
        font-size: .9em;
    }
    </style>
</head>
<body>
  <nav>
    <div class="container">
      <a href="/">entries</a>
      <div>
        <a href="/new">new</a>
        {{ if eq .Kind "single" }}<a href='javascript:alert("\"The past is already written. The ink is dry.\"");'>delete</a> {{ end }}
      </div>
    </div>
  </nav>
  {{ if eq .Kind "single" }}
  {{ $item := index .Entries 0}}
  <article class="container">
      <h1>{{ $item.Date.Format "Monday, 02 Jan 2006 15:04" }}</h1>
      {{ $item.HTML }}
      <p class="tags">{{ $item.TagsToString }}</p>
  </article>
  {{ else if eq .Kind "new" }}
  <form class="container" action="/new" method="post">
    <h1>New Entry</h1>
    <input id="tags" name="tags" placeholder="happy, summer, tags..."></input>
    <textarea id="text" name="text"></textarea>
    <button type="submit">Dry the ink</button>
  </form>
  {{ else if eq .Kind "listing" }}
  <div class="container">
    <h1>Entries</h1>
    {{ if eq .Length 0 }}
    <p>You haven't wrote anything yet :(</p>
    {{ else }}
    <ul>
      {{ range $index, $entry := .Entries }}
        <li><a href="{{ $entry.Date.Format "200601021504" }}">{{ $entry.Date.Format "Monday, 02 Jan 2006 15:04" }}</a></li>
      {{ end }}
    </ul>
    {{ end }}
  </div>
  {{ else }}
  <div class="container">
    <h1 style="text-align:left">Something wrong happened :(</h1>
  </div>
  {{ end }}
</body>
</html>
`
