<?php

/**
 * HEADER CLASS
 *
 * @author Henrique Dias
 * @package MathPocket
 */

require_once('config.php');

class Header {

	public function header() {
		global $DATA;

		$header = new Template(Base::viewsDir('header'));
		$header->LANG = 'pt-PT';
		$header->CSS_VERSION = Base::fileHash('/public_html/css/template.css');
		$header->JS_VERSION = Base::fileHash('/public_html/js/page.js');

		$header->SITE_NAME = SITE_NAME;

		$header->show();

		Base::dbStatus();
	}
}

?>