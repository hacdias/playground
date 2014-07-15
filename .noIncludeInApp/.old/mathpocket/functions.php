<?php

/**
 * Functions of MathPocket app.
 * 
 * @author Henrique Dias
 * @package MathPocket
 *
 * @todo Notificação com Número de ler+tarde
 * @todo Página de Perfil
 * @todo Botão para tirar das listas existentes  
 * e que só apareçam quando estamos na pag delas.
 */

// Call of template system.

require_once("lib/raelgc/view/Template.php");
use raelgc\view\Template;

require_once("lib/user.class.php");
$userClass = new User();

$database;
$colorGlobal;

function connectDatabase() {
	global $database;
	$host = "localhost";

	$username = "root";
	$password = "30164554";
	$dbName = "mathpocket";
	
	$database = new PDO('mysql:host=' . $host . ';dbname=' . $dbName, $username, $password);
	$database->exec("SET NAMES 'utf8';");	
}


function cleanString($string) {
	return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', 
		html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', 
		htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
}

function callHeader($color) {
	global $colorGlobal;
	global $userClass;

	$colorGlobal = cleanString($color);
	$header = new Template("_header.html");
	$header->COLOR = cleanString($color);

	if ( $userClass->loggedIn() === false ) {
		$header->block("BLOCK_LOGIN_MENU");
		$header->block("BLOCK_LOGIN");
	} else {
		$header->USERNAME =  $_SESSION['user_name'];
		$header->block("BLOCK_NAV_USER");
		$header->block("BLOCK_MENU_USER");
		$header->block("BLOCK_LOGOUT");
	}

	$header->show();
}

function displayUserButtons($page) {
	global $userClass;

	if ($userClass->loggedIn() === true) {
		$page->block("BLOCK_USER_ACTIONS");
	}
}

function callFooter() {
	global $colorGlobal;
	$footer = new Template("_footer.html");
	$footer->COLOR = $colorGlobal;
	$footer->show();
}

function printAllItems() {
	global $database;

	callHeader("Blue");

	$page = new Template("_list.html");

	$page->PAGE_TITLE = "Todos os itens";

	$items = $database->query("SELECT * FROM items ORDER BY title"); 

	foreach($items as $item){
		$page->TITLE = $item['title'];
		$page->UTITLE = cleanString($item['title']);
		$page->DESCRIPTION = $item['description'];
		$page->CATEGORY = $item['category'];
		$page->UCATEGORY = cleanString($item['category']);
		displayUserButtons($page);
		$page->block("BLOCK_ITEMS");
		
	}

	$page->show();
}

function getItemsByCategory($category) {
	global $database;

	$page = new Template("_list.html"); 
	$i = 0; 
	$nonExistentCategory = '<p id="search_result">A categoria "'.$category.'" não existe!</p>';

	$items = $database->query("SELECT * FROM items WHERE category LIKE '%".$category."%' ORDER BY title"); 
	$itemsNumber = $items->rowCount();

	if ($itemsNumber == 0){

		callHeader("Red");
		echo $nonExistentCategory;

	} else {

		foreach($items as $item){
			$page->TITLE = $item['title'];
			$page->UTITLE = cleanString($item['title']);
			$page->DESCRIPTION = $item['description'];
			$page->CATEGORY = $item['category'];
			$page->UCATEGORY = cleanString($item['category']);

			displayUserButtons($page);

			$page->block("BLOCK_ITEMS");
			for($i; $i <=0; $i++) {
				$page->PAGE_TITLE = $item['category'];
				callHeader("Orange");
			}
		}

	}
	$page->show();
	
}

function getItemsByTitle($title) {
	global $database;

	$items = $database->query("SELECT * FROM items  ORDER BY title"); 
	
	$page = new Template("_list.html");

	foreach($items as $item){
		if(cleanString($item['title']) == cleanString($title)) {
			callHeader("Green");
			$page->TITLE = $item['title'];
			$page->UTITLE = cleanString($item['title']);
			$page->DESCRIPTION = $item['description'];
			$page->CATEGORY = $item['category'];
			$page->UCATEGORY = cleanString($item['category']);

			displayUserButtons($page);

			$page->block("BLOCK_ITEMS");
			$page->PAGE_TITLE =  $item['title'];
		}
	}
	
	$page->show();
	
}

function search($words) {

	global $database;
	$search = $words;

	$commonWords = array(" e ", " ou ", " em ", " a ", " o ", " se ", " com ", " da ");

	for ($i = 0; $i < count($commonWords); $i++) {
		$words = str_replace($commonWords[$i], ' ', $words);
	}

	$word = explode(" ", $words);
	$query = "SELECT * FROM items WHERE ";

	for ($i = 0; $i < count($word); $i++) {

		if ($i == 0) {
			$query .= "title LIKE '%".$word[$i]."%' OR description LIKE '%".$word[$i]."%' OR category LIKE '%".$word[$i]."%'";
		} else {
			$query .= "OR title LIKE '%".$word[$i]."%' OR description LIKE '%".$word[$i]."%' OR category LIKE '%".$word[$i]."%'";
		}

	}

	$items = $database->query($query); 
	$itemsNumber = $items->rowCount();	
	
	$page = new Template("_list.html");
	$page->PAGE_TITLE = "Pesquisa";

	$noResults = 'Não foram encontrados resultados por "'.$search.'".';
	$existentResults = 'Resultados por "'.$search.'".';

	if ($itemsNumber == 0){
		callHeader("Red");
		$page->SEARCH_MESSAGE = $noResults;
		$page->block("BLOCK_SEARCH");

	} else {
		callHeader("Blue");
		$page->SEARCH_MESSAGE = $existentResults;
		$page->block("BLOCK_SEARCH");
		foreach($items as $item) { 
			$page->TITLE = $item['title'];
			$page->UTITLE = cleanString($item['title']);
			$page->DESCRIPTION = $item['description'];
			$page->CATEGORY = $item['category'];
			$page->UCATEGORY = cleanString($item['category']);

			displayUserButtons($page);
			$page->block("BLOCK_ITEMS");
		} 

	}

	$page->show();  
	
}

function searchNull() {
	callHeader("Red");
	echo '<p id="search_result">Por favor insira um  valor.</p>';
	
}

function callCategories() {
	global $database;

	callHeader("Green");
	$page = new Template("_categories.html");

	$page->PAGE_TITLE = "Categorias";

	$categories = $database->query("SELECT * FROM categories"); 

	foreach($categories as $category){
		$page->CATEGORY = $category['name'];
		$page->SCATEGORY = cleanString($category['name']);
		$page->block("BLOCK_CATEGORIES");
	}

	$page->show();
}

function callAbout() {
	callHeader("Blue");
	$page = new Template("_about.html");
	$page->show();
}

function callSearch() {
	callHeader("Blue");

	$page = new Template("_search.html");
	$page->PAGE_TITLE = "Pesquisa";
	$page->show();
}

function callHome() {
	callHeader("Blue");
	$page = new Template("_home.html");
	$page->show();
}

function callSplashPage() {
	//unset($_COOKIE['mathpocket_splash']);

	setcookie("mathpocket_splash", "splash", time()+60+315576000, "/");
	require "_splash.html";
}

function error404() {
	callHeader("red");
	require '_404.html';
	callFooter();
}

function message($message) {
	$page = new Template("_message.html");
	$page->MESSAGE = $message;
	$page->show();
}

function putUserData($user, $itemTitle, $dataType)  {
	global $database;

	$query = "SELECT ".$dataType." FROM userdata WHERE user = '".$user."'";
	$results = $database->query($query);

	foreach($results as $initialData) {
		$data = $initialData[$dataType];
		$data .= $itemTitle.";";
	}

	$query = "UPDATE userdata SET ".$dataType." = '".$data."' WHERE user = '".$user."'";
	$putIntoTable = $database->query($query);

	if ($dataType === "favorites") {
		$type = "favoritos";
	} else if ($dataType === "read_later") {
		$type = "ler + tarde";
	}

	callHeader("Blue");
	message("Adicionado à lista " . $type . ".");
	callFooter();
}

function callUserData($user, $type) {
	global $database;

	callHeader("orange");

	$page = new Template("_list.html");

	if ($type === "favorites") {
		$pageTitle = "Favoritos";
	} else if ($type === "read_later") {
		$pageTitle = "Ler + tarde";
	} else {
		message("Essa página não existe");
		break;
	}

	$page->PAGE_TITLE = $pageTitle;

	$query = "SELECT ".$type." FROM userdata WHERE user = '".$user."'";
	$results = $database->query($query);

	foreach ($results as $result) {
		$array = explode(";", $result[$type]);
	}

	if (count($array) -1 === 0) {

		$page->show();
		message("Não tem items na lista " . strtolower($pageTitle));

	} else {
		$query = "SELECT * FROM items ";

		for ($i = 0; $i < count($array) -1; $i++) {

			if ($i == 0) {
				$query .= "WHERE title = '" . $array[$i] . "'";
			} else {
				$query .= " OR title = '" . $array[$i] . "'";
			}
		}

		$items = $database->query($query);

		foreach ($items as $item) {
			$page->TITLE = $item['title'];
			$page->UTITLE = cleanString($item['title']);
			$page->DESCRIPTION = $item['description'];
			$page->CATEGORY = $item['category'];
			$page->UCATEGORY = cleanString($item['category']);

			displayUserButtons($page);
			$page->block("BLOCK_ITEMS");
		}

		$page->show();

	}
	
}

/*

function getReadLaterNumber($user) {
	global $database;

	$query = "SELECT read_later FROM userdata WHERE user = '".$user."'";
	$results = $database->query($query);

	foreach ($results as $result) {
		$items = explode(";", $result['read_later']);

		$readLaterNumber = count($items) - 1;
		return $readLaterNumber;
	}
}

*/

?>