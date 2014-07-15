<?php

/**
 * Main page of the web application MathPocket.
 * 
 * @author Henrique Dias
 * @package MathPocket
 */


// Call of template system
require_once("lib/raelgc/view/Template.php");
use raelgc\view\Template;
require 'functions.php';

callHeader("Blue");

connectDatabase();

$name = $_POST['name'];
$user = $_POST['user'];
$pass = sha1($_POST['password']);

if (!$name == "" && !$user == "" && !$pass == ""  )  {

	$confirmIfExists = $database->query("SELECT * FROM users WHERE user = '" . $user ."';");

	if ($confirmIfExists->rowCount() == 0) {
		$query =  "INSERT INTO users(name, user, password) VALUES ('".$name."', '".$user."', '".$pass."')";
		$database->query($query);

		$queryData = "INSERT INTO userdata(user) VALUES ('".$name."')";
		$database->query($queryData);

		$message = new Template("_message.html");
		$message->MESSAGE = "O seu registo foi concluido com sucesso!";

		$message->block("BLOCK_LOGIN");
		$message->show();

	} else {
		$message = new Template("_message.html");
		$message->MESSAGE = "Desculpa, mas já existe um utilizador com o mesmo nome de utilizador!";
		$message->show();
	}	

} else {
	$message = new Template("_message.html");
	$message->MESSAGE = "Não inseriu todos os dados!";
	$message->show();
}

callFooter();

?>