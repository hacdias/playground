<?php

/**
 * FOOTER CLASS
 *
 * @author Henrique Dias
 * @package MathPocket
 */

require_once('config.php');

class Footer {

	public function footer() {

		$footer = new Template(Base::viewsDir('footer'));

		$footer->SITE_NAME = SITE_NAME;
		$footer->ABOUT = _('Sobre');
		
		$footer->show();
	}

}

?>