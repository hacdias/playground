<?php
/**
 * Login page of the web application (MathPocket) backoffice.
 * 
 * @author Henrique Dias
 * @package MathPocket
 */
require_once("../lib/raelgc/view/Template.php");
use raelgc\view\Template;
require '../functions.php';

callHeader("backoffice", "backoffice");

$login = new Template("_login.html");
$login->show();

callFooter();

$style = "<style>
			footer {
				margin: 0 !important;
			}

			.return  {
				display:  none;
			}


		</style>";
echo $style;

?>
