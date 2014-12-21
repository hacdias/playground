<h1>Posts</h1>

<?php foreach ($this->_data as $post) : ?>
    <h2><?php echo $post['title']; ?></h2>
    <p><?php echo $post['content']; ?></p>
<?php endforeach; ?>
