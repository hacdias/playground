<?php

/**
 * SIDEBAR CLASS
 *
 * @author Henrique Dias
 * @package MathPocket
 */

require_once('config.php');

class Sidebar {

	public function sidebar() {
		global $DATA;

		$sidebar = new Template(Base::viewsDir('sidebar'));

		$sidebar->PROFILE = _('Perfil');
		$sidebar->DICTIONARY = _('Dicionário');
		$sidebar->PLEASE_LOGIN = _('Inicie Sessão');


		if ($DATA['userSession']->loggedIn() === false ) {

			$sidebar->USER = 'default';
			$sidebar->USERPHOTO = 'default';

			$sidebar->block('LOGIN_MENU');
			$sidebar->block('LOGIN');

		} else {

			$sidebar->USERPHOTO = $DATA['user']->getPhoto($_SESSION['user_user']);
			$sidebar->USER = $_SESSION['user_user'];
			$sidebar->COLOR = $DATA['user']->getColor($_SESSION['user_user'], true);
			$sidebar->USERNAME =  $_SESSION['user_name'];
			$sidebar->block('NAV_USER');
		}
		
		$sidebar->show();
	}
}

?>