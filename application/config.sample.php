<?php

/**
 * Config File
 *
 * This file contains the base configuration of this website:
 *  1. Base Constants
 *  2. Directories Constants
 *  3. Database Configuration Data
 *  4. Some SEO configurations
 *  5. Errors settings
 *
 * Always provide a trailing slash (/) after a path.
 *
 * @package     InMVC
 * @subpackage  Configuration
 */

date_default_timezone_set('Europe/London');

/*
 * 1. Base Constants
 *
 * @cons string ROOT This constant contains the absolute path to the main folder ('application');
 * @cons string URL The URL of the application;
 * @cons string SITE_TITLE The title of the application;
 * @cons string MODE The current mode of the application (DEVELOPMENT or PRODUCTION).
 */
define('ROOT', dirname(__FILE__) . '/');
define('URL', 'http://localhost/mvc/');
define('SITE_TITLE', 'InMVC');
define('MODE', 'DEVELOPMENT');

/*
 * 2. Directories Constants
 *
 * @cons string DIR_VIEWS The absolute path to the views directory;
 * @cons string DIR_PUBLIC The path to the public_html directory;
 */
define('DIR_VIEWS', ROOT . 'views/');
define('DIR_PUBLIC', '../www/');

/*
 * 3. Database Configuration Data
 *
 * This configuration is only needed if you want to use
 * a database.
 */
define('DB_TYPE', 'dbtype');
define('DB_HOST', 'dbhost');
define('DB_NAME', 'dbname');
define('DB_USER', 'dbuser');
define('DB_PASS', 'dboass');

/*
 * 4. Some SEO settings
 *
 * @cons string DEFAULT_DESCRIPTION The default description to appear in <meta> tags;
 * @cons string DEFAULT_KEYWORDS The default keywords to appear in <meta> tags;
 */
define('DEFAULT_DESCRIPTION', '');
define('DEFAULT_KEYWORDS', '');

/*
 * 5. Errors settings
 *
 * Set display_errors:
 *  to Off to hide all PHP errors;
 *  to On to display all PHP errors;
 *
 * Set error_reporting:
 *  to -1 to report all PHP errors;
 *  to 0 to report none of PHP errors;
 *
 * Set log_errors:
 *  to Off if you don't want to log the errors;
 *  to On if you want to log the errors;
 *
 * Error_log:
 *  Define the file where the log will be saved.
 *
 */
switch (MODE) {
    case 'DEVELOPMENT':
        ini_set('display_errors','On');
        break;
    case 'PRODUCTION':
    default:
        ini_set('display_errors','Off');
        break;
}

ini_set('error_reporting', -1);
ini_set('log_errors','On');
ini_set('error_log', ROOT . 'errors.log');
