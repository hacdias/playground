<?

COISAS VELHAS QUE ESTOU A REAPROVEITAR 


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