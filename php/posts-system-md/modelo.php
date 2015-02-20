<!doctype html>
<html lang='pt-PT'>

<head>

    <title><?php echo $titulo; ?></title>

    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta name='keyword' content=''>
    <meta name='description' content=''>

    <link type="text/css" rel="stylesheet" href="<?php echo URL; ?>css/normalize.css">
    <link type="text/css" rel="stylesheet" href="<?php echo URL; ?>css/style.css">
</head>

<body>

    <header id="header">

    </header>

    <div id="content">

        <div class="title-container">
            <div class="container">
                <h1><?php echo $titulo; ?></h1>
            </div>
        </div>

        <div class="container">
            <?php echo $conteudo; ?>
        </div>

    </div>

    <footer id="footer">
        <div class="container">
            <p>Um simples sistema de posts</p>
        </div>
    </footer>

</body>
</html>
