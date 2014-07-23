<?php

/**
 * PAGE CLASS
 *
 * @author Henrique Dias, Alexandre Reis
 * @package MathPocket
 */

require_once('config.php');

class Piece {

	protected $page;
	protected $color;

	public function __construct($page = '', $color = 'blue') {
		$this->page = $page;
		$this->color = $color;

		switch ($page) {
			case 'header':
				$this->header();
				break;

			case 'footer':
				$this->footer();
				break;

			case 'sidebar':
				$this->sidebar();
				break;

			default:
				$this->index();
				break;
		}
	}

	protected function header() {

		$header = new Template(Base::viewsDir('header'));
		$header->LANG = 'pt-PT';
		$header->CSS_VERSION = Base::fileHash('/public_html/css/template.css');
		$header->JS_VERSION = Base::fileHash('/public_html/js/page.js');

		$header->SITE_NAME = SITE_NAME;

		$header->show();
	}

	protected function footer() {

		$footer = new Template(Base::viewsDir('footer'));

		$footer->SITE_NAME = SITE_NAME;
		$footer->ABOUT = _('Sobre');

		$footer->show();
	}

	protected function sidebar() {
		global $DATA;

		$sidebar = new Template(Base::viewsDir('sidebar'));

		if ($DATA['user']->loggedIn() === false ) {

			$sidebar->USER = 'default';
			$sidebar->USERPHOTO = 'default';

			$sidebar->block('LOGIN_MENU');
			$sidebar->block('LOGIN');

		} else {

			$sidebar->USERPHOTO = User::getPhoto($_SESSION['user_user']);
			$sidebar->USER = $_SESSION['user_user'];
			$sidebar->COLOR = User::getColor($_SESSION['user_user'], true);
			$sidebar->USERNAME =  $_SESSION['user_name'];
			$sidebar->block('NAV_USER');
		}
		
		$sidebar->show();
	}

	protected function index() {
		global $DATA;

		$DATA['page'] = new Template(Base::viewsDir($this->page));
		$DATA['page']->COLOR = Base::cleanString($this->color);

		if ($DATA['page']->exists('SITE_NAME')) {
			$DATA['page']->SITE_NAME = SITE_NAME;
		}

		$DATA['page']->show();
	}
}

?>