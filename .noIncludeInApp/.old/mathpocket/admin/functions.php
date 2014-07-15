<?php

/**
 * Functions of MathPocket backoffice.
 * 
 * @author Henrique Dias
 * @package MathPocket
 */

require_once("../lib/raelgc/view/Template.php");
use raelgc\view\Template;

$database;

function connectDatabase() {
	global $database;
	$host = "localhost";

	$username = "root";
	$password = "30164554";
	$dbName = "mathpocket";
	
	$database = new PDO('mysql:host=' . $host . ';dbname=' . $dbName, $username, $password);
	$database->exec("SET NAMES 'utf8';");	
}

function callHeader($title, $color) {
	global $colorGlobal;
	$colorGlobal = cleanString($color);
	$header = new Template("_header.html");

	if ($title == "")  {
		echo "<style> .page_title { display: none !important; } </style>";
	} else {
		$header->PAGE_TITLE = $title;
	}

	$header->COLOR = cleanString($color);
	$header->show();
}


function cleanString($string) {
	return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', 
		html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', 
		htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
}


function callFooter() {
	global $colorGlobal;
	$footer = new Template("_footer.html");
	$footer->COLOR = $colorGlobal;
	$footer->show();
}

function message($msg) {
	$page = new Template('_message.html');
	$page->MESSAGE = $msg;
	$page->show();
}

function itemChange($page, $editType) {
	global $database;

 	callHeader($editType . " Item", "backoffice");
	
	$page = new Template($page);

	$items = $database->query("SELECT title FROM items ORDER BY title"); 
	$itemsNumber = $items->rowCount();

	foreach($items as $item){
		$page->TITLE = $item['title'];
		$page->block("BLOCK_ITEMS");
	}

	$page->show();
	
}

function addItem() {
	callHeader("Adicionar Item", "backoffice");
	
	$page = new Template("_addItem.html");
	$page->show();
}

function addCategory() {
	callHeader("Adicionar Categoria", "backoffice");
	
	$page = new Template("_addCategory.html");
	$page->show();
}

function remItem() {
	$page = "_remItem.html";
	$editType = "Remover";
	itemChange($page, $editType);
}

function remCategory() {
	callHeader("Remover Categoria", "backoffice");
	
	$page = new Template("_remCategory.html");
	$page->show();
}

function editItem() {
	$page = "_editItem.html";
	$editType = "Editar";
	itemChange($page, $editType);
}

function editItemName() {
	callHeader("Editar nome de Item", "backoffice");

	$page = new Template("_editItemName.html");
	$page->show();
}

function editCategory() {
	callHeader("Editar Categoria", "backoffice");
	
	$page = new Template("_editCategory.html");
	$page->show();
}

?>
