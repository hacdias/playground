<?php

/**
 * CONFIGURATION FILE
 *
 * @author Henrique Dias <me@henriquedias.com>
 * @package MathPocket
 */

define('HOST_URL', 'http://' . $_SERVER['HTTP_HOST']);

if ($_SERVER['REQUEST_URI'] == '/config.php' || $_SERVER['REQUEST_URI'] == '/router.php') {  
	header( 'Location: ' . HOST_URL . '/404' );
}

define('HOST_DIR', 'D:/Dev/mathspot');
define('SITE_NAME', 'MathSpot');

foreach (glob(HOST_DIR . "/modules/*.php") as $filename) {
    require_once($filename);
}

$DATA = array(
	'user'			=> new User()		,
	'db'        	=> null      		);

$host     = 'localhost';
$username = 'root';
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
	$footer = new Piece('footer');

	die;
}

?>