<?php

/**
 * UPDATE TABLE CLASS
 *
 * @author Henrique Dias
 * @package MathPocket
 */

require_once('config.php');

class UpdateTable {

	function __construct() {
		$this->updateSlug();
	}

	function updateSlug() {
		$items = SQL::selectAll('i_con');

		foreach ($items as $item) {

			$utitle = Base::cleanString($item['category']);

			SQL::updateOne('i_con', 'u_category', $utitle, 'title', $item['title']);

		}
	}

}

?>