<?php

/**
 * Main file.
 *
 * @package InMVC
 */
require '../app_core/config.php';

function autoLoad($className)
{
    require DIR_LIBS . $className . '.php';
}

spl_autoload_register('autoLoad');

$bootstrap = new \Bootstrap();
$bootstrap->init();
