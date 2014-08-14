<?php
require 'config.php';
$person = new \Person();

function __autoload($class) {
    require LIBS . $class .".php";
}

$bootstrap = new \Bootstrap();
$bootstrap->init();