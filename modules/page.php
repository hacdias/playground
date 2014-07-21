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

	public function __construct($page = '', $color = 'blue') {
		$this->page = $page;
		$this->color = $color;

		$this->index();
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