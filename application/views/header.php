<!doctype html>
<html lang='en-EN'>

<head>

<title><?php echo (isset($this->_pageInfo['title'])) ? $this->_pageInfo['title'] : SITE_TITLE; ?></title>

<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<meta name='keyword' content='<?php echo $this->_pageMeta['keywords']; ?>'>
<meta name='description' content='<?php echo $this->_pageMeta['description']; ?>'>

<?php

$files = array(
    'css'   => array(
        'css/template',
        'assets/normalize.css/normalize'),
    'js'    => array(
        'js/page'
    )
);

$this->printAssets($files); ?>
</head>

<body>

<div id='header'>

    <nav id="nav">
        <ul>
            <a href="<?php echo URL; ?>"><li><strong><?php echo SITE_TITLE; ?></strong></li></a>
            <a href="<?php echo URL; ?>page"><li>Page</li></a>
            <a href="<?php echo URL; ?>posts"><li>Posts</li></a>
        </ul>
    </nav>

</div>

<div id="wrap">
