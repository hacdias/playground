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

callHeader("Editar Categoria",  "backoffice");

if (isset($_GET['name'])) {
	$name = $_GET["name"];

	$confirmIfExists = $database->query("SELECT * FROM categories WHERE name = '" . $name ."';");

	if ($confirmIfExists->rowCount() == 0) {
		message("Não existem entradas com o título inserido!");
	} else {
		$items = $confirmIfExists;
		$page = new Template("_editCategoryForm.html");
		
		foreach($items as $item) {
			$page->NAME = $item['name'];
		}

		$page->show();		
	}
	
} else {
	header("Location: /admin/");
	exit;
}

callFooter();

?>
