<?php

/**
 * Logout Script.
 * 
 * @author Henrique Dias
 * @package MathPocket
 */

include("secure.php");
session_destroy();
header("Location: index.php");
exit;

?>