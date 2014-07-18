<?php

/**
 * FAVORITES CLASS
 *
 * @author Henrique Dias
 * @package MathPocket
 */

require_once('config.php');

class Favorites {

	static function addFav($itemId, $user) {
		global $DATA;

		$query = $DATA['db']->query("SELECT favs FROM users WHERE user ='" . $user . "';");

		foreach ($query as $item) {
			$favs = $item['favs'];
		}

		$favs .= $itemId . ';';

		SQL::updateOne('users', 'favs', $favs, 'user', $user);

	}

	
}

?>