<?php

/**
 * Delete Category Page.
 * 
 * @author Henrique Dias
 * @package MathPocket
 */

include("secure.php"); 
protect(); 

/*
 * Call of template system and all application common
 * functions file.
 */
require_once("../lib/raelgc/view/Template.php");
use raelgc\view\Template;
require 'functions.php';

connectDatabase();

callHeader("Remover Item",  "backoffice");

if (isset($_GET['name'])) {
	$name = $_GET["name"];

	$confirmIfExists = $database->query("SELECT * FROM categories WHERE name = '" . $name ."';");

	if ($confirmIfExists->rowCount() > 0) {
		$database->query("DELETE FROM  `mathpocket`.`categories` WHERE  `categories`.`name` = '" . $name . "' LIMIT 1 ;");
		message("Entrada removida.");
	} else {
		message("Não existem entradas com o título inserido!");
	}
	
}

callFooter();

?>
