<?php

/**
 * Main page of the web application (MathPocket) backoffice.
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

if (isset($_GET['add'])) {
	$url = $_GET["add"];

	switch ($url) {
		case "item":
			addItem();
			break;

		case "category":
			addCategory();
			break;

		default:
			header("Location: /admin/");
			exit;
			break;
	}
} else if (isset($_GET['rem'])) {
	$url = $_GET["rem"];

	switch ($url) {
		case "item":
			remItem();
			break;

		case "category":
			remCategory();
			break;

		default:
			header("Location: /admin/");
			exit;
			break;
	}

} else if (isset($_GET['edit'])) {
	$url = $_GET["edit"];

	switch ($url) {
		case "item":
			editItem();
			break;

		case "itemname":
			editItemName();
			break;

		case "category":
			editCategory();
			break;

		default:
			header("Location: /admin/");
			exit;
			break;
	}
} else {
	callHeader("Admin", "backoffice");
	$page = new Template("_home.html");
	$page->show();
}

callFooter();

?>
