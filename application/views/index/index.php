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

<body class="splash all-page">

    <div class="autoBackgroud all-page splash0"></div>

    <div class="splash1 all-page">

        <div class="ghost"></div>
        <div class="container align-middle-w-ghost">
            <h1 class="site-title title-font"><a href="<?php echo URL; ?>">Secure Notes</a></h1>
            <h2 class="site-subtitle title-font">Be simple. Be secure.</h2>
            <br>
            <span class="new-note buttons form-item"><a href="<?php echo URL; ?>new">New Note →</a></span>
        </div>

    </div>

</body>
</html>
