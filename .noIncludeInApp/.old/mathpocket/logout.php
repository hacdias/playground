<?php
// Inclui o arquivo com a classe de login
require_once("lib/user.class.php");
// Instancia a classe
$userClass = new User();

// Usuário fez logout com sucesso?
if ( $userClass->logout() ) {
	// Redireciona pra tela de login
	header("Location: login.php");
	exit;
}
?>