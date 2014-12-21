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
 *
 * @package     InMVC
 * @subpackage  Configuration
 */

//1. Base Constants
define('ROOT', dirname(__FILE__) . '/');
define('URL', 'http://localhost/mvc/');
define('SITE_TITLE', 'InMVC');

//2. Directories Constants
define('DIR_LIBS', ROOT . 'libs/');
define('DIR_MODELS', ROOT . 'models/');
define('DIR_VIEWS', ROOT . 'views/');
define('DIR_CONTROLLERS', ROOT . 'controllers/');
define('DIR_PUBLIC', '../public_html/');

//3. Database Configuration Data
define('DB_TYPE', 'dbtype');
define('DB_HOST', 'dbhost');
define('DB_NAME', 'dbname');
define('DB_USER', 'dbuser');
define('DB_PASS', 'dbpass');

date_default_timezone_set('Europe/London');

define('DEFAULT_DESCRIPTION', '');
define('DEFAULT_KEYWORDS', '');

// 4. Errors settings
/*
 * Set display_errors:
 *  to Off to hide all PHP errors;
 *  to On to display all PHP errors;
 */
ini_set('display_errors','On');
/*
 * Set error_reporting:
 *  to -1 to report all PHP errors;
 *  to 0 to report none of PHP errors;
 */
ini_set('error_reporting', -1);
/*
 * Set log_errors:
 *  to Off if you don't want to log the errors;
 *  to On if you want to log the errors;
 */
ini_set('log_errors','On');
/*
 * Define the file where the log will be saved.
 */
ini_set('error_log', ROOT . 'errors.log');
