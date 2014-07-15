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

callHeader("Editar Item",  "backoffice");

if (isset($_GET['title'])) {
	$title = $_GET["title"];

	$confirmIfExists = $database->query("SELECT * FROM items WHERE title = '" . $title ."';");

	if ($confirmIfExists->rowCount() == 0) {
		message("Não existem entradas com o título inserido!");
	} else {
		$items = $confirmIfExists;
		$page = new Template("_editItemForm.html");
		
		foreach($items as $item) {
			$page->TITLE = $item['title'];
			$page->DESCRIPTION = $item['description'];
			$page->CATEGORY = $item['category'];
		}

		$page->show();		
	}
	
} else {
	header("Location: /admin/");
	exit;
}

callFooter();

?>
