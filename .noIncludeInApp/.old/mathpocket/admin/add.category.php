<?php

/**
 * Add Category Page.
 * 
 * @author Henrique Dias
 * @package MathPocket
 */

include("secure.php"); 
protect(); 

require_once("../lib/raelgc/view/Template.php");
use raelgc\view\Template;
require 'functions.php';

connectDatabase();

callHeader("Adicionar Categoria",  "backoffice");

if (isset($_GET['name'])) {
	$name = $_GET["name"];

	$confirmIfExists = $database->query("SELECT * FROM categories WHERE name = '" . $name ."';");

	if ($confirmIfExists->rowCount() > 0) {
		message("Já existe uma entrada com esse nome.");
	} else {
		$database->query("INSERT INTO categories(name) VALUES ('" . $name ."')");
		message("Entrada inserida.");
	}
}

callFooter();

?>
