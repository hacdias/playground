<!doctype html>
<html lang='en-EN'>

<head>

<title><?php echo (isset($data['title'])) ? $data['title'] . ' | ' . SITE_TITLE : SITE_TITLE; ?></title>

<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<meta name='keyword' content='<?php echo (isset($data['keywords'])) ? $data['keywords'] : DEFAULT_KEYWORDS; ?>'>
<meta name='description' content='<?php echo (isset($data['description'])) ? $data['description'] : DEFAULT_DESCRIPTION; ?>'>

<?=$data['assets']?>
</head>

<body>

<nav class="autoBackgroud navbar">
    <div class="container ">
        <span class="site-title title-font left"><a href="<?php echo URL; ?>new">Secure Notes</a></span><span class="right"><a href="<?php echo URL; ?>new"><img src="<?php echo URL; ?>imgs/plus.png"/></a><!--<img src="<?php echo URL; ?>imgs/view.png"/>--></span>
    </div>
</nav>

<div class="container">
