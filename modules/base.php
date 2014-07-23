<?php

/**
 * BASE CLASS with common functions
 *
 * @author Henrique Dias, Alexandre Reis
 * @package MathPocket
 */

class Base {

	static public function viewsDir($page) {
		return HOST_DIR . '/views/' . $page . '.html';
	}

	static public function cleanString($string) {

		return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', 
html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', 
htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));

	}

	static public function fileHash($dir) {
		return md5_file(HOST_DIR . $dir);
	}

	static public function needLogin() {
		$options = array();
		$options['needLogin'] = true;

		echo "<script> var options = eval('( "  . json_encode($options) .  ")'); </script>";

		$DATA['page'] = new Piece('login');
	}

}

?>