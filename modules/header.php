<?php

/**
 * HEADER CLASS
 *
 * @author Henrique Dias
 * @package CodePocket
 */

require_once('config.php');

class Header extends Base {

	public function header() {
		global $DATA;

		$DATA['page'] = new Template($this->viewsDir('header'));
		$DATA['page']->CSS_VERSION = $this->fileHash('/css/template.css');
		$DATA['page']->JS_VERSION = $this->fileHash('/js/page.js');

		$DATA['page']->SITE_NAME = SITE_NAME;

		if ($DATA['userSession']->loggedIn() === false ) {

			$DATA['page']->USER = 'default';
			$DATA['page']->USERPHOTO = 'default';

			$DATA['page']->block('LOGIN_MENU');
			$DATA['page']->block('LOGIN');

		} else {

			$DATA['page']->USERPHOTO = $DATA['user']->getPhoto($_SESSION['user_user']);
			$DATA['page']->USER = $_SESSION['user_user'];
			$DATA['page']->COLOR = $DATA['user']->getColor($_SESSION['user_user'], true);
			$DATA['page']->USERNAME =  $_SESSION['user_name'];
			$DATA['page']->block('NAV_USER');
		}

		
		$DATA['page']->show();
		$this->dbStatus();
	}
}

?>