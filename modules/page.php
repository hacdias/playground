<?php

/**
 * PAGE CLASS
 *
 * @author Henrique Dias
 * @package MathPocket
 */

require_once('config.php');

class Page extends Base {

	protected $page;
	protected $color;
	protected $options;

	public function __construct($page = '', $color = 'blue', $options = array('wrong'		=>	false,
															 				'needData'	=>	false,
															 				'alreadyExists'	=> false,
															 				'needLogin'		=>	false)) {
		$this->page = $page;
		$this->color = $color;
		$this->options = $options;


		switch ($page) {
			case 'register':
				$this->registerPage();
				break;

			default:
				$this->index();
		}
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

	protected function registerPage() {
		global $DATA;

		if (!$DATA['user']->loggedIn()) {

			$DATA['page'] = new Template(Base::viewsDir($this->page));
			$DATA['page']->COLOR = Base::cleanString($this->color);

			if ($this->options['alreadyExists']) {

				$DATA['page']->block('ALREADY_EXISTS');

			} else if ($this->options['needData']) {

				$DATA['page']->block('NEED_DATA');

			}

			$DATA['page']->show();

		} else {
			$this->message('Já tem a sessão iniciada!');
		}
	}

}

?>