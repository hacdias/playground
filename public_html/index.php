<?php

/**
 * INDEX
 *
 * @author Henrique Dias <me@henriquedias.com>
 * @package MathPocket
 *
 */

require_once('/config.php');

$header = new Piece('header'); 

require_once('/router.php');

$footer = new Piece('footer');


?>
		<div id="sidebar">

			<?php $sidebar = new Piece('sidebar'); ?>

		</div>
	</body>
</html>