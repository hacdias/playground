<!doctype html>
<html lang='en-EN'>

<head>

    <title><?php echo (isset($data['title'])) ? $data['title'] : SITE_TITLE; ?></title>

    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta name='keyword' content='<?php echo (isset($data['keywords'])) ? $data['keywords'] : DEFAULT_KEYWORDS; ?>'>
    <meta name='description'
          content='<?php echo (isset($data['description'])) ? $data['description'] : DEFAULT_DESCRIPTION; ?>'>

    <?= $data['assets'] ?>
</head>

<body>

<div id='header'>

    <nav id="nav">
        <ul>
            <a href="<?php echo URL; ?>">
                <li><strong><?php echo SITE_TITLE; ?></strong></li>
            </a>
            <a href="<?php echo URL; ?>page">
                <li>Page</li>
            </a>
            <a href="<?php echo URL; ?>posts">
                <li>Posts</li>
            </a>
        </ul>
    </nav>

</div>

<div id="wrap">
