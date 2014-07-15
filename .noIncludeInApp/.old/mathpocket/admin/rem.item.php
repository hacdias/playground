<?php

/**
 * Delete Item Page.
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

if (isset($_GET['title'])) {
	$title = $_GET["title"];

	$confirmIfExists = $database->query("SELECT * FROM items WHERE title = '" . $title ."';");

	if ($confirmIfExists->rowCount() > 0) {
		$database->query("DELETE FROM  `mathpocket`.`items` WHERE  `items`.`title` = '" . $title . "' LIMIT 1 ;");
		message("Entrada removida.");
	} else {
		message("Não existem entradas com o título inserido!");
	}
	
}

callFooter();

?>
