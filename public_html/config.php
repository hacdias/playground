<?php

/**
 * CONFIGURATION FILE
 *
 * @author Henrique Dias
 * @package CodePocket
 */


define('HOST_URL', 'http://' . $_SERVER['HTTP_HOST']);
define('HOST_DIR', 'D:/Dev/mathpocket');
define('SITE_NAME', 'MathPocket');

foreach (glob(HOST_DIR . "/modules/*.php") as $filename) {
    require_once($filename);
}

$DATA = array(
	'userSession'	=> new UserSession(),
	'user'			=> new User()		,
	'db'        	=> null      		,
	'db_status' 	=> null      		,
	'sql'			=> new Sql()		,
	'page'      	=> null      		,
	'footer'    	=> null      		,
	'url'      		=> null      		);

$host     = 'localhost';
$username = 'root';
$password = '5VcDgpPpJoyp';
$db 	  = 'mathpocket';

try {

	$DATA['db'] = new PDO('mysql:host=' . $host . ';dbname=' . $db, $username, $password);
	$DATA['db'] ->exec("SET NAMES 'utf8';");

	$DATA['db_status'] = true;

} catch (PDOException $error) {

	$DATA['db_status'] = false;

}

?>