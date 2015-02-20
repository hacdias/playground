<?php

require 'functions.php';

$url = obterUrl();

if (count($url) > 1) {
    echo 'Error 404. Not Found.';
    exit();
}

if ($url[0] === 'index') {
    $conteudo = obterConteudoPagInicial();
    mostrarPagina('Posts SyS', $conteudo);
    exit();
}

$nomeDoPost = $url[0];
$nomeDoPost = slugify($nomeDoPost);

$postCru = obterPostCru($nomeDoPost);
$info = obterInfo($postCru);

mostrarPagina($info['TITLE'], $info['POST']);
