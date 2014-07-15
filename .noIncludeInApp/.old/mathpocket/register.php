<?php

/**
 * Main page of the web application MathPocket.
 * 
 * @author Henrique Dias
 * @package MathPocket
 */


// Call of template system
require_once("lib/raelgc/view/Template.php");
use raelgc\view\Template;
require 'functions.php';

callHeader("Blue");

connectDatabase();

$register = new Template("_register.html");
$register->PAGE_TITLE = "Registo";
$register->show();

callFooter();

?>