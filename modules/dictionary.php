<?php

/**
* DICTIONARY CLASS
*
* @author Henrique Dias, Alexandre Reis
* @package MathPocket
*/

require_once('config.php');

class Dictionary {

	protected $maxItens = 15;

	protected function getOffset($n) {
		return ($n - 1) * $this->maxItens;
	}

	protected function getMaxPage($query) {
		return ceil($query / $this->maxItens); 
	}

	protected function isInList($itemId, $user, $thing) {
		$query = SQL::selectOneWhereLimit($thing, 'users', 'user', $user);

		if ($query) {

			foreach ($query as $item) {
				$items = $item[$thing];
			}

			$isInList = false;

			$items = explode(',', $items);

			for ($i = 0; $i < count($items); $i++) {

				if ($items[$i] == $itemId) {
					$isInList = true;
				}

			}

			return $isInList;

		} else {
			return 'Error';
		}
	}

	protected function display($items, $maxPages = 1, $n = 0, $url = 'dictionary/') {
		global $DATA;

		if ($n > $maxPages) {

			$page = new Piece('404', 'red');

		} else {

			$page = new Template(Base::viewsDir("items"));

			foreach($items as $item){

				$page->ID = $item['id'];

				if ($DATA['user']->loggedIn(true, false)) {

					$id = $item['id'];
					$user = $_SESSION['user_user'];

					$page->block( ($this->isInList($id, $user, 'favs')) ? 'REMFAV' : 'ADDFAV' );
					$page->block( ($this->isInList($id, $user, 'later')) ? 'REMLATER' : 'ADDLATER' );

				}

				$page->TITLE = $item['title'];
				$page->UTITLE = Base::cleanString($item['title']);
				$page->DESCRIPTION = $item['description'];
				$page->CATEGORY = $item['category'];
				$page->UCATEGORY = Base::cleanString($item['category']);
				$page->block("ITEM");
			}

			$page->URL = $url;

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

	public function allItems($n = 1) {
		$maxPages = $this->getMaxPage(SQL::rowNumber('i_con')); 

		$items = SQL::selectAllOrderLimitOffset('i_con', 'title', $this->maxItens, $this->getOffset($n));

		$this->display($items, $maxPages, $n);

	}

	public function item($utitle) {

		if (SQL::rowNumberWhere('i_con', 'u_title', $utitle) == 0) {

			$page = new Piece('404', 'red');

		} else {

			$items = SQL::selectAllWhere('i_con', 'u_title', $utitle);
			$this->display($items);

		}
	}

	public function category($ucategory, $n = 1) {

		if (SQL::rowNumberWhere('i_con', 'u_category', $ucategory) == 0) {

			$page = new Piece('404', 'red');

		} else {

			$maxPages = $this->getMaxPage(SQL::rowNumberWhere('i_con', 'u_category', $ucategory)); 

			$items = SQL::selectAllOrderWhereLimitOffset('i_con', 'u_category', $ucategory, 'title', $this->maxItens, $this->getOffset($n));
			$url = 'dictionary/' . $ucategory . '/';

			$this->display($items, $maxPages, $n, $url);
		}
	}

	public function listFavLater($user, $thing) {
		global $DATA;

		$query = SQL::selectOneWhereLimit($thing, 'users', 'user', $user);

		if($query) {

			foreach ($query as $item) {
				$itemsIds = $item[$thing];
			}

			if ($itemsIds != '' && $itemsIds != null) {

				$itemsIds = rtrim($itemsIds, ',');

				$items = SQL::selectAllWhereMultipleOrder('i_con', 'id', $itemsIds, 'title');
				$this->display($items);

			} else  {

				echo "<div class='main {COLOR}'>
			<div class='content'><p>Ainda não adicionou itens a esta lista!</p></div></div>";

			}

		} else {

			//Consulta mal sucedida

		}
	}

	static function actionFavLater($itemId = 0, $user, $thing, $action) {
		global $DATA;

		if ($DATA['user']->loggedIn() && $_SESSION['user_user'] == $user) {

			$result = array();

			if ($itemId != 0) {

				if (!User::exists($user)) {

					$result['status'] = 1;

				} else {

					$query = SQL::selectOneWhereLimit($thing, 'users', 'user', $user);

					if($query) {

						foreach ($query as $item) {
							$new = $item[$thing];
						}

						$confirm = explode(',', $new);

						$alsoExists = false;

						for ($i = 0; $i < count($confirm); $i++) {

							if($confirm[$i] == $itemId) {

								$alsoExists = true;

							}

						}

						if (!$alsoExists) {

							if ($action == 'add') {

								$new .= $itemId . ',';

								if(SQL::updateOne('users', $thing, $new, 'user', $user)) {

									$result['status'] = 0;

								} else {

									$result['status'] = 3;

								}

							} else if ($action == 'rem') {

								$result['status'] = 6;

							}


						} else {

							if ($action == 'add') {

								$result['status'] = 2;

							} else if ($action == 'rem') {

								$new = str_replace($itemId . ',', '', $new);

								if(SQL::updateOne('users', $thing, $new, 'user', $user)) {

									$result['status'] = 0;

								} else {

									$result['status'] = 3;

								}

							} else {

								$result['status'] = 6;

							}
						}

					} else {

						$result['status'] = 3;

					}
				}

			} else {

				$result['status'] = 4;

			}

		} else {

			$result['status'] = 5;

		}

		ob_end_clean();
		header('Content-type: application/json');
		echo json_encode($result);
	}

	function lastThreeAdded($user, $thing) {
		global $DATA;

		$query = SQL::selectOneWhereLimit($thing, 'users', 'user', $user); 

		if ($query)  {

			foreach ($query as $row) {
				$itemsList = $row[$thing];
			}

			$itemsList = rtrim($itemsList, ',');
			$itemsList = explode(',', $itemsList);

			//$itemsNumber

		} else {
			//Consulta mal sucedida
		}

	}

	/* function search($words) { 

		global $DATA;

		$search = $words;

		$commonWords = array('e', 'a', 'as', 'o', 'os', 'da', 'das', 'do', 'dos', 'na', 'nas', 'no', 'nos', 'ou', 'com', 'sem');

		for ($i = 0; $i < count($commonWords); $i++) {
			$words = str_replace(' ' . $commonWords[$i] . ' ', ' ', $words);
		}

		$word = explode(" ", $words);

		$query = "SELECT * FROM items WHERE ";

		for ($i = 0; $i < count($word); $i++) {

			if ($i == 0) {

				$query .= "title LIKE '%".$word[$i]."%' OR description LIKE '%".$word[$i]."%' OR category LIKE '%".$word[$i]."%'";

			} else {

				$query .= " OR title LIKE '%".$word[$i]."%' OR description LIKE '%".$word[$i]."%' OR category LIKE '%".$word[$i]."%'";

			}

		}
		
		$itemsNumber = ($DATA['db']->query($query))->rowCount();

		$query .= 	


		$page->show();  

	} */ 

}

?>