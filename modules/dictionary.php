<?php

/**
* DICTIONARY CLASS
*
* @author Henrique Dias <me@henriquedias.com>
* @package MathPocket
*/

class Dictionary {

	/**
	 * The max itens per page.
	 * @var	int
	 */
	protected $maxItens = 15;

	/**
	 * Get Offset
	 *
	 * @param	int $n	Actual page number.
	 * @return	the offset to be used in a query.
	 */
	protected function getOffset($n) {
		return ($n - 1) * $this->maxItens;
	}

	/**
	 * Get Max Page
	 *
	 * @param	int	$n	number of itens.
	 * @return	the max pages number.
	 */
	protected function getMaxPage($n) {
		return ceil($n / $this->maxItens); 
	}

	/**
	 * Confirm if the $user has the item on the $list.
	 *
	 * There are only two lists: 'favs' and  'later'. Any 
	 * other is invalid.
	 *
	 * @param	int $itemId		The ID of the item.
	 * @param	string $user	The username of the user.
	 * @param	string $list	The name of the list.
	 *
	 * @return	a boolean value or 'Error' if an error occurred.
	 */
	protected function isInList($itemId, $user, $list) {
		$query = SQL::selectWhereLimit($list, 'users', 'user', $user);

		if ($query) {

			foreach ($query as $item) {
				$items = $item[$list];
			}

			$isInList = false;

			$items = explode(',', $items);

			for ($i = 0; $i < count($items); $i++) {

				if ($items[$i] === $itemId) {
					$isInList = true;
					break;
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

			$page = new Template(Helper::viewsDir("items"));

			foreach($items as $item){

				$page->ID = $item['id'];

				if ($DATA['user']->loggedIn(true, false)) {

					$id = $item['id'];
					$user = $_SESSION['user_user'];

					$page->block( ($this->isInList($id, $user, 'favs')) ? 'REMFAV' : 'ADDFAV' );
					$page->block( ($this->isInList($id, $user, 'later')) ? 'REMLATER' : 'ADDLATER' );

				}

				$page->TITLE = $item['title'];
				$page->UTITLE = Helper::cleanString($item['title']);
				$page->DESCRIPTION = $item['description'];
				$page->CATEGORY = $item['category'];
				$page->UCATEGORY = Helper::cleanString($item['category']);
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

			if (!$items) {
				$page = new Piece('404', 'red');
			} else  {
				$this->display($items);
			}
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

		$query = SQL::selectWhereLimit($thing, 'users', 'user', $user);

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

		$result = array();

		do {

			if ( !$DATA['user']->loggedIn() && !$_SESSION['user_user'] == $user)
				{ $result['status'] = 5; break; }

			if ( $itemId < 1 ) 
				{ $result['status'] = 4; break; }

			if ( !User::exists($user) )
				{ $result['status'] = 1; break; }

			$query = SQL::selectWhereLimit($thing, 'users', 'user', $user);

			if ( !$query ) 
				{ $result['status'] = 3; break; }

			foreach ($query as $item) {
				$new = $item[$thing];
			}

			$confirm = explode(',', $new);

			$alsoExists = false;

			for ($i = 0; $i < count($confirm); $i++) {

				if($confirm[$i] === $itemId) {

					$alsoExists = true;

				}

			}

			if (!$alsoExists) {

				if ($action == 'add') {

					$new .= $itemId . ',';

					$result['status'] = ( SQL::updateOne('users', $thing, $new, 'user', $user) ) ? 0 : 3;

				} else if ($action == 'rem') {

					$result['status'] = 6;

				}


			} else {

				if ($action == 'add') {

					$result['status'] = 2;

				} else if ($action == 'rem') {

					$new = str_replace($itemId . ',', '', $new);

					$result['status'] = ( SQL::updateOne('users', $thing, $new, 'user', $user) ) ? 0 : 3;

				} else {

					$result['status'] = 6;

				}
			}

		} while (0);

		ob_end_clean();
		header('Content-type: application/json');
		echo json_encode($result);

	}

	/**
	 * @todo complete this:
	 */

	function lastThreeAdded($user, $thing) {
		global $DATA;

		$query = SQL::selectWhereLimit($thing, 'users', 'user', $user); 

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
		
		$itemsNumber = ($DATABASE->query($query))->rowCount();

		$query .= 	


		$page->show();  

	} */ 

}

?>