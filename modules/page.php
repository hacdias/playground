<?php

/**
 * PAGE CLASS
 *
 * @author Henrique Dias
 * @package CodePocket
 */

require_once('config.php');

class Page extends Base {

	protected $page;
	protected $color;
	protected $wrong;
	protected $needData;
	protected $alreadyExists;
	protected $needLogin;

	public function __construct($page = '', $color = 'blue', $wrong = false, $needData = false, $alreadyExists = false, $needLogin = false) {
		$this->page = $page;
		$this->color = $color;
		$this->wrong = $wrong;
		$this->needData = $needData;
		$this->alreadyExists = $alreadyExists;
		$this->needLogin = $needLogin;

		if ($page == 'login') {
			$this->loginPage();
		} else if ($page == 'register') {
 			$this->registerPage();
		} else if ($page == 'needDataAdmin') {
			$this->message('Nada feito porque faltam vários dados :(');
		} else if ($page = '') {
			//DO NOTHING
		} else {
			$this->index();
		}
	}

	protected function index() {
		global $DATA;

		$DATA['page'] = new Template($this->viewsDir($this->page));
		$DATA['page']->COLOR = $this->cleanString($this->color);

		if ($DATA['page']->exists('SITE_NAME')) {
			$DATA['page']->SITE_NAME = SITE_NAME;
		}

		$DATA['page']->show();
	}

	protected function loginPage() {
		global $DATA;

		if (!$DATA['userSession']->loggedIn()) {

			$DATA['page'] = new Template($this->viewsDir($this->page));
			$DATA['page']->COLOR = $this->cleanString($this->color);

			if ($this->wrong) {

				$DATA['page']->block('WRONG');

			} else if ($this->needData) {

				$DATA['page']->block('NEED_DATA');

			} else if ($this->needLogin) {

				$DATA['page']->block('LOGIN_MSG');

			}

			$DATA['page']->show();

		} else {
			$this->message('Já tem a sessão iniciada!');
		}

	}

	protected function registerPage() {
		global $DATA;

		if (!$DATA['userSession']->loggedIn()) {

			$DATA['page'] = new Template($this->viewsDir($this->page));
			$DATA['page']->COLOR = $this->cleanString($this->color);

			if ($this->alreadyExists) {

				$DATA['page']->block('ALREADY_EXISTS');

			} else if ($this->needData) {

				$DATA['page']->block('NEED_DATA');

			}

			$DATA['page']->show();

		} else {
			$this->message('Já tem a sessão iniciada!');
		}
	}

}

?>