#Ajax Call with a PHP Answer#

This is a small example of what we can do with Ajax and its calls. The objective
of this example is show how we can do an Ajax call and answer it with PHP.

For this, we use a simple registry form. The user put the info on the form and
clicks on "Submit" and the Ajax sends the info to the server. Then, PHP gets the info and process it. After it, PHP responds with json.

##Folder Structure##

+ css
  - style.css
+ js
  - script.js
+ db.sqlite
+ index.html
+ process.php

##What do each file?##

| File | Description |
| ---- | ----------- |
| css/style.css | The stylesheet of the page |
| js/script.js | Get the info from the form, send it to the server and read the server-answer |
| db.sqlite | A simple SQLite database to run the query. |
| index.html | The HTML file where the form is placed. |
| process.php | Where the info is processed. |
