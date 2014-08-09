<?php

/**
 * CONFIGURATION FILE
 *
 * @author Henrique Dias <me@henriquedias.com>
 * @package MathPocket
 */

define('SITE_NAME', 'MathSpot');
define('DEVELOPMENT_ENVIRONMENT', true);

if (DEVELOPMENT_ENVIRONMENT == true) {

    error_reporting(E_ALL);
    ini_set('display_errors','On');

} else {

    error_reporting(E_ALL);
    ini_set('display_errors','Off');
    ini_set('log_errors', 'On');
    ini_set('error_log', ROOT . DS. 'error.log');

}

if ($_SERVER['REQUEST_URI'] == '/config.php' || $_SERVER['REQUEST_URI'] == '/router.php') {
	header( 'Location: ' . URL . '/404' );
}

foreach (glob(ROOT . DS . 'modules' . DS . '*.php') as $filename) {
    require_once($filename);
}

$DATA = array(
	'user'			=> new User()		,
	'db'        	=> null      		);

$host     = 'localhost';
$username = 'roota';
$password = '5VcDgpPpJoyp';
$db 	  = 'mathspot';

try {

	$DATABASE = new PDO('mysql:host=' . $host . ';dbname=' . $db, $username, $password);
	$DATABASE->exec("SET NAMES 'utf8';");

	$dbStatus = true;

} catch (PDOException $error) {

	$dbStatus = false;
}

if (!$dbStatus) {

	$page = new Piece('header');
	$page = new Piece('tecnical',  'red');
    $page = new Piece('sidebar');
	$footer = new Piece('footer');

	die;
}
