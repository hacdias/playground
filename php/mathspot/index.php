<?php

require 'config.php';

spl_autoload_register(function ($class) {
    include LIBS . $class . '.php';
});

$person = new \Person();

$bootstrap = new \Bootstrap();
$bootstrap->init();