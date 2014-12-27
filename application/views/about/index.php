<h1><span class="title-font">Secure Notes</span> is made with ♥</h1>

<p>This web application allows you to create secure notes that only the person who has the correct link and the correct password can open. If you want to know more about how this application works, read below.</p>

<h2>How does it works?</h2>

<p>Firstly, we should say that all of the encryption is done in the client-side, i.e., the data never come to the server without being encrypted. We only store encrypted data. After you fill the form in <strong>/new</strong>, the note is automatically encrypted in your browser and the password is hashed. After it, the data is sent to the server.</p>

<p>Then this data come to the server, the password hash is encrypted and stored in the database and the encrypted note is also saved. When the note is encrypted, a key is generated and this key is the only key that can decrypt the note. We don't store this key so we can't decrypt your notes.</p>

<p>Who saves this key is you in the URL. After the creation of the note you will be redirected to a page whose url has this structure: <strong>/{id}#{key}</strong>.</p>

<p>On that page a request your password will be requested. If the password is correct, the encrypted note will also be requested and decrypted in your browser using the key that's passed by the url hash. If you lose the key/entire url nor you, nor we will can decrypt the note.</p>
