<script src="//cdn.ckeditor.com/4.4.6/standard/ckeditor.js"></script>

<h2>New Note</h2>

<div class="advice-box hidden"></div>

<form class="note-form" method="post" action="javascript:createNote()">
    <p>Your note:</p>
    <textarea name="content" id="content" class="form-item"></textarea>

    <p>Password:</p>
    <input class="form-item" id="password" type="password" name="password">
    <button class="buttons form-item" type="submit" name="submit">Create</button>
</form>

<script>
    CKEDITOR.replace('content');
</script>
