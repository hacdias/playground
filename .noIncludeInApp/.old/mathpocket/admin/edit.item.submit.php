<?php

/**
 * Edit Item Page.
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

callHeader("Editar Item", "backoffice");

if (isset($_GET['title']) && isset($_GET['description']) && isset($_GET['category'])) {
	$title = $_GET["title"];
	$description = $_GET["description"];
	$category = $_GET["category"];

	$confirmIfExists = $database->query("SELECT * FROM items WHERE title = '" . $title ."';");

	$database->query("UPDATE items
				   SET title = '" . $title . "', 
				   	   description = '" . $description . "',
				   	   category = '" . $category . "'
				 WHERE title = '" . $title . "'");

	message("Atualização bem sucedida!");
}

callFooter();

?>
