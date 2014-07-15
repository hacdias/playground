<?php

/**
 * Main page of the web application MathPocket.
 * 
 * @author Henrique Dias
 * @package MathPocket
 */

require_once("lib/raelgc/view/Template.php");
use raelgc\view\Template;
require 'functions.php';

require_once("lib/user.class.php");
$userClass = new User();

if (!isset($_COOKIE["mathpocket_splash"])) {

	callSplashPage();
	
} else {

	connectDatabase();

	if (isset($_GET['title'])) {

		$url = $_GET["title"];
		getItemsByTitle($url);

	} else if (isset($_GET['category'])) {

		$url = $_GET["category"];
		getItemsByCategory($url);

	} else if (isset($_GET['page'])) {

		$url = $_GET["page"];

		switch ($url) {
			case "about":
				callAbout();
				break;

			case "categories":
				callCategories();
				break;

			case "all":
				printAllItems();
				break;

			case "search":
				callSearch();
				break;

			case "404":
				error404();
				break;

			case "favorites":

				if ($userClass->loggedIn()) {
					callUserData($_SESSION['user_user'], $url);
				} else {
					noSignedIn();
				}

				break;

			case "readlater":

				if ($userClass->loggedIn()) {
					callUserData($_SESSION['user_user'], "read_later");
				} else {
					noSignedIn();
				}

				break;

			default:
				header("Location: /");
				exit;
				break;
		}

	} else if (isset($_GET['search'])){

		$url = $_GET["search"];

		if ($url) {
			search($url);
		} else {
			searchNull();
		}	

	} else if (isset($_POST['addReadLater'])) {

		$url = $_POST['addReadLater'];

		if ($url) {
			if ($userClass->loggedIn()) {
				putUserData($_SESSION['user_user'], $url, "read_later");
			}
		} else {
			header("Location: /");
			break;
		}

	} else if (isset($_POST['addFavorites'])) {

		$url = $_POST['addFavorites'];

		if ($url) {
			if ($userClass->loggedIn())  {
				putUserData($_SESSION['user_user'], $url, "favorites");
			}
		} else {
			header("Location: /");
			break;
		}

	} else {

		callHome();

	}	

	callFooter();
}

?>