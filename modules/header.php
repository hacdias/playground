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
		$header->CSS_VERSION = Base::fileHash('/css/template.css');
		$header->JS_VERSION = Base::fileHash('/js/page.js');

		$header->SITE_NAME = SITE_NAME;

		$header->PROFILE = _('Perfil');
		$header->ABOUT = _('Sobre');
		$header->PLEASE_LOGIN = _('Inicie Sessão');


		if ($DATA['userSession']->loggedIn() === false ) {

			$header->USER = 'default';
			$header->USERPHOTO = 'default';

			$header->block('LOGIN_MENU');
			$header->block('LOGIN');

		} else {

			$header->USERPHOTO = $DATA['user']->getPhoto($_SESSION['user_user']);
			$header->USER = $_SESSION['user_user'];
			$header->COLOR = $DATA['user']->getColor($_SESSION['user_user'], true);
			$header->USERNAME =  $_SESSION['user_name'];
			$header->block('NAV_USER');
		}
		
		$header->show();

		Base::dbStatus();
	}
}

?>