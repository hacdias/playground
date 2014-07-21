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

require_once('/router.php');

$footer = new Footer();


?>
		<div id="sidebar">

			<?php $sidebar = new Sidebar(); ?>

		</div>
	</body>
</html>