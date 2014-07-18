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
		$items = SQL::selectAllWhere('i_con', 'u_title', $utitle);
		$this->display($items);

	}

	public function category($ucategory, $n = 1) {

		$maxPages = ceil(SQL::rowNumberWhere('i_con', 'u_category', $ucategory) / $this->maxItens); 

		$items = SQL::selectAllOrderWhereLimitOffset('i_con', 'u_category', $ucategory, 'title', $this->maxItens, $this->getOffset($n));

		$this->display($items, $maxPages, $n);
		
	}

	protected function display($items, $maxPages = 1, $n = 0) {

		if ($n > $maxPages) {

			echo "<script>page('404');</script>";

		} else {

			$page = new Template(Base::viewsDir("items"));

			foreach($items as $item){
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
}

?>