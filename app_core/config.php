<?php

/**
 * Config File
 *
 * This file contains the base configuration of this website:
 *  1. Base Constants
 *  2. Directories Constants
 *  3. Database Configuration Data
 *  4. Errors settings
 *
 * Always provide a trailing slash (/) after a path.
 */

//1. Base Constants
define('ROOT', dirname(__FILE__) . '/');
define('URL', 'http://localhost/mvc/');
define('SITE_TITLE', 'Simple MVC Structure Model');

//2. Directories Constants
define('DIR_LIBS', ROOT . 'libs/');
define('DIR_MODELS', ROOT . 'models/');
define('DIR_VIEWS', ROOT . 'views/');
define('DIR_CONTROLLERS', ROOT . 'controllers/');
define('DIR_PUBLIC', '../public_html/');

//3. Database Configuration Data
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'mvc');
define('DB_USER', 'root');
define('DB_PASS', 'root');

/*
 * 4. Errors settings
 *
 * Set error_reporting:
 *  to -1 to display all PHP errors;
 *  to 0 to hide all PHP errors;
 */
error_reporting(-1);
ini_set('display_errors', '-1');