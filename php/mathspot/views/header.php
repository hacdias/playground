<!doctype html>
<html lang='pt-PT'>

<head>
    <title>MathSpot</title>

    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <link rel="stylesheet" href="/public/assets/jquery-ui/themes/smoothness/jquery-ui.css" />
    <link rel='stylesheet' href='<?php echo URL; ?>public/css/template.css?v=<?php echo $this->_cssHash; ?>' type='text/css' media='all' />

    <meta name='apple-mobile-web-app-title' content='MathSpot'>

    <link rel='apple-touch-icon-precomposed' href='<?php echo URL; ?>public/imgs/touch-icon.png'>
    <link rel='icon' sizes='196x196' href='<?php echo URL; ?>public/imgs/touch-icon.png'>

    <script src="/public/assets/jquery/dist/jquery.min.js"></script>
    <script src="/public/assets/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?php echo URL; ?>public/js/page.js?v=<?php echo $this->_jsHash; ?>"></script>

</head>

<body>
<div id='header'>

    <span class="btnz">
        <label for='menu-checkbox' id='menu-btn'>
            <span id='menu-btn-div'></span>
        </label>
    </span>

    <a onClick="page('')">
        <span class="logo"></span>
    </a>

    <span id='header_title'><a onClick="page('')">MathSpot</a></span>

</div>

<div id="wrap">
