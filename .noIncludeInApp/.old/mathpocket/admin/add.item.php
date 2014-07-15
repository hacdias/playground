<?php

/**
 * Add Item Page.
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

callHeader("Adicionar Item",  "backoffice");

if (isset($_GET['title']) && isset($_GET['description']) && isset($_GET['category'])) {
	$title = $_GET["title"];
	$description = $_GET["description"];
	$category = $_GET["category"];

	$confirmIfExists = $database->query("SELECT * FROM items WHERE title = '" . $title ."';");

	if ($confirmIfExists->rowCount() > 0) {
		message("Já existe uma entrada com esse nome.");
	} else {
		$database->query("INSERT INTO items(title, description, category) VALUES ('" . $title ."','" . $description ."','" . $category ."')");
		message("Entrada inserida.");
	}
}

callFooter();

?>
