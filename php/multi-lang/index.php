<?php
require_once('i18n.php'); 
?>

<!DOCTYPE html>
<html lang="<?php echo $locale; ?>">
  <head>
    <meta charset="UTF-8" />
    <title><?php echo __('Hello World!'); ?></title>
  </head>
  <body>
    <h1><?php _e('Hello World!'); ?></h1>
  </body>
</html>