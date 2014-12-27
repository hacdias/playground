<?php

define('START_TIME', microtime(true));

/**
* Main File
*
* This is the file where everything starts. The
* configuration is required, the auto load class
* is declared and the Bootstrap is initialized.
*
* @package     InMVC
*/
if(file_exists('../application/config.php')) {
    require '../application/config.php';
} else {
    die("There's no configuration file.");
}

require '../application/helpers/dir.php';
use \Helpers\Dir as Dir;

/**
* Auto Load Function
*
* This function is able to Auto Load the necessary
* classes that are inside the library folder.
*
* @param string $className The name of the unknown class.
*/
function autoLoad($className)
{
    $file = Dir::preparePath(ROOT . $className . '.php');

    if (file_exists($file))
    require $file;
}

spl_autoload_register('autoLoad');
\Core\Bootstrap::init();
