<?php

/**
 * INDEX
 *
 * @author Henrique Dias
 * @package MathPocket
 *
 */

require_once('/config.php');

$header = new Header(); 
$sidebar = new Sidebar();

require_once('/router.php');

$footer = new Footer();

?>