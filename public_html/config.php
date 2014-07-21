<?php

/**
 * CONFIGURATION FILE
 *
 * @author Henrique Dias
 * @package MathPocket
 */

define('HOST_URL', 'http://' . $_SERVER['HTTP_HOST']);

if ($_SERVER['REQUEST_URI'] == '/config.php' || $_SERVER['REQUEST_URI'] == '/router.php') {  
	header( 'Location: ' . HOST_URL . '/404' );
}

define('HOST_DIR', 'D:/Dev/mathpocket');
define('SITE_NAME', 'MathPocket');

foreach (glob(HOST_DIR . "/modules/*.php") as $filename) {
    require_once($filename);
}

$DATA = array(
	'userSession'	=> new UserSession(),
	'user'			=> new User()		,
	'db'        	=> null      		,
	'page'      	=> null      		);

$host     = 'localhost';
$username = 'root';
$password = '5VcDgpPpJoyp';
$db 	  = 'mathpocket';

try {

	$DATA['db'] = new PDO('mysql:host=' . $host . ';dbname=' . $db, $username, $password);
	$DATA['db']->exec("SET NAMES 'utf8';");

	define('DB_STATUS', true);

} catch (PDOException $error) {

	define('DB_STATUS', false);

}

?>