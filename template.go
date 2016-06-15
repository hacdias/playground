package main

const templateString = `<!doctype html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.1.1/normalize.min.css">

    <style>
    * {
        box-sizing: border-box;
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
    textarea {
        width: 100%;
        min-height: 32em;
        font-size: 1em;
        resize: vertical;
        border: 1px dashed #212121;
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
  <article class="container">
      <h1>{{ .Date.Format "2006-01-02 15:04" }}</h1>
      {{ .Text }}
  </article>
  {{ else if eq .Kind "new" }}
  <form class="container" action="." method="post">
    <h1>New Entry</h1>
    <textarea id="msg" name="user_message"></textarea>
    <button type="submit">Send your message</button>
  </form>
  {{ else }}
  <div class="container">
    <h1>Entries</h1>
    <ul>
      <li>2016-08-08</li>
      <li>2016-08-24</li>
      <li>2016-08-30</li>
      <li>2016-09-06</li>
      <li>2016-09-12</li>
      <li>2016-09-22</li>
      <li>2016-10-05</li>
      <li>2016-10-12</li>
      <li>2016-10-13</li>
      <li>2016-10-14</li>
      <li>2016-10-24</li>
      <li>2016-10-26</li>
      <li>2016-10-28</li>
      <li>2016-11-01</li>
      <li>2016-11-03</li>
      <li>2016-11-07</li>
      <li>2016-11-08</li>
      <li>2016-11-11</li>
      <li>2016-11-28</li>
      <li>2016-12-02</li>
      <li>2016-12-06</li>
      <li>2016-12-07</li>
      <li>2016-12-08</li>
      <li>2016-12-12</li>
      <li>2016-12-16</li>
    </ul>
  </div>
  {{ end }}
</body>
</html>
`
