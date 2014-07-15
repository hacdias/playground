<?php

/**
 * Edit Category Page.
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

callHeader("Editar nome de item",  "backoffice");

if (isset($_GET['name'])) {
	$name = $_GET["name"];

	$confirmIfExists = $database->query("SELECT title FROM items WHERE title = '" . $name ."';");

	if ($confirmIfExists->rowCount() == 0) {
		message("Não existem entradas com o título inserido!");
	} else {
		$items = $confirmIfExists;
		$page = new Template("_editItemNameForm.html");
		
		foreach($items as $item) {
			$page->NAME = $item['title'];
		}

		$page->show();		
	}
	
} else {
	header("Location: /admin/");
	exit;
}

callFooter();

?>
