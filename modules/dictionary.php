<?php

/**
 * DICTIONARY CLASS
 *
 * @author Henrique Dias
 * @package MathPocket
 */

require_once('config.php');

class Dictionary {

	protected $maxItens = 15;

	protected function getOffset($n) {
		return ($n - 1) * $this->maxItens;
	}

	public function allItems($n = 1) {
		$maxPages = ceil(SQL::rowNumber('i_con') / $this->maxItens); 

		$items = SQL::selectAllOrderLimitOffset('i_con', 'title', $this->maxItens, $this->getOffset($n));

		$this->display($items, $maxPages, $n);

	}

	public function item($utitle) {

		if (SQL::rowNumberWhere('i_con', 'u_title', $utitle) == 0) {

			$page = new Page('404', 'red');

		} else {

			$items = SQL::selectAllWhere('i_con', 'u_title', $utitle);
			$this->display($items);

		}
	}

	public function category($ucategory, $n = 1) {

		if (SQL::rowNumberWhere('i_con', 'u_category', $ucategory) == 0) {

			$page = new Page('404', 'red');
			
		} else {

			$maxPages = ceil(SQL::rowNumberWhere('i_con', 'u_category', $ucategory) / $this->maxItens); 

			$items = SQL::selectAllOrderWhereLimitOffset('i_con', 'u_category', $ucategory, 'title', $this->maxItens, $this->getOffset($n));

			$this->display($items, $maxPages, $n);
		}
	}

	protected function display($items, $maxPages = 1, $n = 0) {
		global $DATA;

		if ($n > $maxPages) {

			$page = new Page('404', 'red');

		} else {

			$page = new Template(Base::viewsDir("items"));

			foreach($items as $item){

				$page->ID = $item['id'];

				if ($DATA['userSession']->loggedIn()) {
					$page->block('USER_ACTIONS');
				}
				
				$page->TITLE = $item['title'];
				$page->UTITLE = Base::cleanString($item['title']);
				$page->DESCRIPTION = $item['description'];
				$page->CATEGORY = $item['category'];
				$page->UCATEGORY = Base::cleanString($item['category']);
				$page->block("ITEM");
			}

			if ($n > 1) {
				$page->PREV_N = $n - 1;
				$page->block('PREV');
			}
			
			if ($n < $maxPages && $n != 0) {
				$page->NEXT_N = $n + 1;
				$page->block('NEXT');
			}
			
			$page->show();

		}
	}

	/*

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
	*/

}

?>