<?php

// Always provide a TRAILING SLASH (/) AFTER A PATH
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS);
define('URL', 'http://8df5v1s98d51vcxa4815scdx.dynip.sapo.pt/');
define('LIBS', 'libs/');

define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'mathspot');
define('DB_USER', 'root');
define('DB_PASS', '5VcDgpPpJoyp');

error_reporting(E_ALL);
ini_set( 'display_errors','1');

error_log('teste');
