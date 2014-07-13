<?php

/**
 * FOOTER CLASS
 *
 * @author Henrique Dias
 * @package CodePocket
 */

require_once('config.php');

class Footer {

	public function footer() {
		global $DATA;

		$DATA['footer'] = new Template(HOST_DIR . '/views/footer.html');
		$DATA['footer']->SITE_NAME = SITE_NAME;
		$DATA['footer']->show();
	}

}

?>