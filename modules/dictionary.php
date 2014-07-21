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

	protected function isInList($itemId, $user, $thing) {
		$query = SQL::selectOneWhereLimit($thing, 'users', 'user', $user);

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
	}

	protected function display($items, $maxPages = 1, $n = 0) {
		global $DATA;

		if ($n > $maxPages) {

			$page = new Page('404', 'red');

		} else {

			$page = new Template(Base::viewsDir("items"));

			foreach($items as $item){

				$page->ID = $item['id'];

				if ($DATA['user']->loggedIn()) {

					$id = $item['id'];
					$user = $_SESSION['user_user'];

					if ($this->isInList($id, $user, 'favs')) {
						$page->block('REMFAV');
					} else {
						$page->block('ADDFAV');
					}

					if ($this->isInList($id, $user, 'later')) {
						$page->block('REMLATER');
					} else {
						$page->block('ADDLATER');
					}
					
				}
				
				$page->TITLE = $item['title'];
				$page->UTITLE = Base::cleanString($item['title']);
				$page->DESCRIPTION = $item['description'];
				$page->CATEGORY = $item['category'];
				$page->UCATEGORY = Base::cleanString($item['category']);
				$page->block("ITEM");
			}

			/**
			 * @todo fix bug next and prev pages like category, favs, later, etc.
			 */

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
	<div class='content'>Ainda não adicionou itens a esta lista!</div></div>";
			}

		} else {
			//Consulta mal sucedida
		}

	}

	static function actionFavLater($itemId = 0, $user, $thing, $action) {
		global $DATA;

        /*
         *  STATUS MAP
         *
         *  0 =>    Nenhum problema
         *  1 =>    Utilizador Inexistente
         *  2 =>    Item já gravado na lista em questão
         *  3 =>    Problema na base de dados
         *  4 =>    Item inválido
         *  5 =>    Sem sessão Iniciada
         *  6 =>    Operação Inválida
         *
         */

		if ($DATA['user']->loggedIn()) {

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