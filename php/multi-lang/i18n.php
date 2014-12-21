<?php

require_once('config.php');

$locale = LANG;
$textdomain = "multi_lang";
$locales_dir = dirname(__FILE__) . '/lang';

if (isset($_GET['lang']) && !empty($_GET['lang'])) {
    $locale = $_GET['lang'];
}

putenv('LANGUAGE=' . $locale);
putenv('LANG=' . $locale);
putenv('LC_ALL=' . $locale);
putenv('LC_MESSAGES=' . $locale);

require_once('lib/gettext.inc');

_setlocale(LC_ALL, $locale);
_setlocale(LC_CTYPE, $locale);

_bindtextdomain($textdomain, $locales_dir);
_bind_textdomain_codeset($textdomain, 'UTF-8');
_textdomain($textdomain);

/*
 * This function is an helper that should be
 * used to avoid some repetitions. Use "_e"
 * instead of "echo __".
 */
function _e($string) {
    echo __($string);
}
