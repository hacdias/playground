<?php

/**
 * BASE CLASS with common functions
 *
 * @author Henrique Dias
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

	static public function dbStatus() {

		if (!DB_STATUS) {
			$page = new Page('tecnical',  'red');
			$footer = new Footer();

			die;
		}
	}

	static public function fileHash($dir) {
		return md5_file(HOST_DIR . $dir);
	}

	static public function message($message, $color =  'blue', $loginButton = false) {
		global $DATA;

		$DATA['page'] = new Template(Base::viewsDir('message'));
		$DATA['page']->MESSAGE = $message;
		$DATA['page']->COLOR = $color;

		if ($loginButton) {
			$DATA['page']->block('MESSAGE_LOGIN');
		} 

		$DATA['page']->show();
	}

	protected function adminMessage($msg) {
		global $DATA;

		$DATA['page'] = new Template($this->viewsDir('admin/main'));
		$DATA['page']->COLOR = 'orange';

		$DATA['page']->block('ADVICE_' . strtoupper($msg));

		$DATA['page']->show();
	}

}

?>