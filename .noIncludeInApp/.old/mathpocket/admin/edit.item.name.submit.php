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

callHeader("Editar o Nome de Item",  "backoffice");

if (isset($_GET['nameInitial']) && $_GET['nameFinal']) {
	$nameInitial = $_GET["nameInitial"];
	$nameFinal = $_GET["nameFinal"];

	$confirmIfExists = $database->query("SELECT * FROM items WHERE title = '" . $nameInitial ."';");

	$database->query("UPDATE items
				   SET title = '" . $nameFinal . "'
				 WHERE title = '" . $nameInitial . "'");

	message("Atualização bem sucedida!");
}

callFooter();

?>
