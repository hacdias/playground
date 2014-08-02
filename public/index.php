<?php

/**
 * INDEX
 *
 * @author Henrique Dias <me@henriquedias.com>
 * @package MathPocket
 *
 */

define('ROOT', dirname(dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);
define('URL', 'http://' . $_SERVER['HTTP_HOST']);

$load = isset($_GET['load']) ? $_GET['load'] : 'all';

require_once(ROOT . DS . 'config.php');

if ($load === 'all') {
	$header = new Piece('header'); 
}

require_once(ROOT . DS . 'routes.php');

if ($load === 'all') {

	$footer = new Piece('footer');
	
?>
		<div id="sidebar">

			<?php $sidebar = new Piece('sidebar'); ?>

		</div>
	</body>
</html> <?php
}