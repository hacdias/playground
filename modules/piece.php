<?php

/**
 * PAGE CLASS
 *
 * @author Henrique Dias <me@henriquedias.com>
 * @package MathPocket
 */

class Piece {

	protected $page;
	protected $color;
	protected $options;

	public function __construct($page = '', $color = 'blue', $options = array()) {
		$this->page = $page;
		$this->color = $color;
		$this->options = $options;

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

			case '404':
				header('HTTP/1.0 404 Not Found');
				$this->index();
				break;

			default:
				$this->index();
				break;
		}
	}

	protected function header() {

		$header = new Template(Helper::viewsDir('header'));
		$header->LANG = 'pt-PT';
		$header->CSS_VERSION = Helper::fileHash(DS . 'public' . DS . 'css' . DS . 'template.css');
		$header->JS_VERSION = Helper::fileHash(DS . 'public' . DS . 'js' . DS . 'page.js');

		$header->SITE_NAME = SITE_NAME;

		$header->show();
	}

	protected function footer() {

		$footer = new Template(Helper::viewsDir('footer'));

		$footer->SITE_NAME = SITE_NAME;
		$footer->ABOUT = _('Sobre');

		$footer->show();
	}

	protected function sidebar() {
		global $DATA;

		$sidebar = new Template(Helper::viewsDir('sidebar'));

		if (isset($this->options['load']) && $this->options['load'] === 'all')  {
			$sidebar->block('ALL_1');
		}

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

		if (isset($this->options['load']) && $this->options['load'] === 'all')  {
			$sidebar->block('ALL_2');
		}

		$sidebar->show();
	}

	protected function index() {
		global $DATA;

		$DATA['page'] = new Template(Helper::viewsDir($this->page));
		$DATA['page']->COLOR = Helper::cleanString($this->color);

		if ($DATA['page']->exists('SITE_NAME')) {
			$DATA['page']->SITE_NAME = SITE_NAME;
		}

		if ($DATA['page']->exists('BASE_URL')) {
			$DATA['page']->BASE_URL = URL;
		}

		$DATA['page']->show();
	}
}
