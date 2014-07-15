<?php
/**
 * Login confirmation script.
 * 
 * @author Henrique Dias
 * @package MathPocket
 */

include("secure.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$user = (isset($_POST['user'])) ? $_POST['user'] : '';
	$pass = (isset($_POST['pass'])) ? $_POST['pass'] : '';

	if (confirmUser($user, $pass) == true) {
		header("Location: index.php");
	} else {
		expel();
	}
}
?>