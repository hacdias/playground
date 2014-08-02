<?php

/**
 * This class has the basic functions of MathSpot. These functions
 * can be used in all source files.
 *
 * @author		Henrique Dias <me@henriquedias.com>
 * @package		MathPocket
 * @subpackage	Base
 */

class Helper {


	/**
	 * Views Directory.
	 *
	 * @param	string $page	The name  of the .html page that is saved in /views/ directory.
	 *
	 * @return	The method returns the URL to the HTML page ($page).
	 */
	static public function viewsDir($page) {
		return ROOT . DS . 'views' . DS . $page . '.html';
	}

	/**
	 * Clean String.
	 *
	 * @param	string $string	The string to be cleaned.
	 * @return	The method returns a string "slugged".
	 *
	 */
	static public function cleanString($string) {

		return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', 
html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', 
htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));

	}

	/**
	 * File Hash
	 * 
	 * @param	string $dir	The file directory.
	 * @return	MD5 hash of the file.
	 **/
	static public function fileHash($dir) {
		return md5_file(ROOT . $dir);
	}

	static public function needLogin() {
		$options = array();
		$options['needLogin'] = true;

		echo "<script> var options = eval('( "  . json_encode($options) .  ")'); </script>";

		$DATA['page'] = new Piece('login');
	}

}

?>