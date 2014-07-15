<?php
// Inclui o arquivo com a classe de login
require_once("lib/user.class.php");
// Instancia a classe
$userClass = new User();

// Pega os dados vindos do formulário
$user = $_POST['user'];
$pass = $_POST['pass'];
// Se o campo "lembrar" não existir, o script funcionará normalmente
$remember = (isset($_POST['remember']) AND !empty($_POST['remember']));

// Tenta logar o usuário com os dados
if ( $userClass->login( $user, $pass, $remember ) ) {
	// Usuário logado com sucesso, redireciona ele para a página restrita
	header("Location: index.php");
	exit;
} else {
	// Não foi possível logar o usuário, exibe a mensagem de erro
	echo "<strong>Erro: </strong>" . $userClass->erro;
}
?>