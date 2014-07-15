<?php

/**
 * Security script.
 * 
 * @author Henrique Dias
 * @package MathPocket
 */

$_SG['connectServer'] = true;   
$_SG['openSession'] = true;         
$_SG['caseSensitive'] = true;     
$_SG['alwaysConfirm'] = true; 
$_SG['loginPage'] = 'login.php';       

/*
 * Database connect info.
 */
$_SG['table'] = 'admins';
$_SG['server'] = 'localhost'; 


$_SG['user'] = 'root';    
$_SG['pass'] = '30164554';         
$_SG['database'] = 'mathpocket';

if ($_SG['connectServer']) {
	$serverError = "MySQL: Não foi possível conectar-se ao server [".$_SG['server']."].";
	$databaseError = "MySQL: Não foi possível conectar-se ao database de dados [".$_SG['database']."].";

	$_SG['link'] = mysql_connect($_SG['server'], $_SG['user'], $_SG['pass']) or die($serverError);
	mysql_select_db($_SG['database'], $_SG['link']) or die( $databaseError);
}

if ($_SG['openSession']) {
	session_start();
}

function confirmUser($user, $pass) {
	global $_SG;

	$cS = ($_SG['caseSensitive']) ? 'BINARY' : '';

	$nuser = addslashes($user);
	$npass = addslashes($pass);

	$sql = "SELECT `id`, `name` FROM `".$_SG['table']."` WHERE ".$cS." `user` = '".$nuser."' AND ".$cS." `pass` = '".$npass."' LIMIT 1";
	$query = mysql_query($sql);
	$result = mysql_fetch_assoc($query);

	if (empty($result)) {
		return false;

	} else {
		$_SESSION['userID'] = $result['id'];
		$_SESSION['userName'] = $result['name']; 

		if ($_SG['alwaysConfirm'] == true) {
			$_SESSION['userLogin'] = $user;
			$_SESSION['userPass'] = $pass;
		}

		return true;
	}
}

function protect() {
	global $_SG;

	if (!isset($_SESSION['userID']) OR !isset($_SESSION['userName'])) {
		expel();
	} else if (!isset($_SESSION['userID']) OR !isset($_SESSION['userName'])) {
		if ($_SG['alwaysConfirm'] == true) {
			if (!confirmUser($_SESSION['userLogin'], $_SESSION['userPass'])) {
				expel();
			}
		}
	}
}

function expel() {
	global $_SG;
	unset($_SESSION['userID'], $_SESSION['userName'], $_SESSION['userLogin'], $_SESSION['userPass']);
	header("Location: ".$_SG['loginPage']);
}
?>