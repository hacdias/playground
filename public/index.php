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
define('URL', 'http://8df5v1s98d51vcxa4815scdx.dynip.sapo.pt');

$load = isset($_GET['load']) ? $_GET['load'] : 'all';

require_once(ROOT . DS . 'config.php');

if ($load === 'all') {
	$header = new Piece('header');
}

require_once(ROOT . DS . 'routes.php');

if ($load === 'all') {

	$footer = new Piece('footer');
	$sidebar = new Piece('sidebar', 'blue', array('load'	=> $load));
}
