<?php

namespace Helpers;

/**
 * Json Class
 *
 * Some useful function to use with Json.
 *
 * @package     InMVC
 * @subpackage  Helpers
 */
abstract class Json
{
    private static $baseInfo = array(
        'application'   =>  SITE_TITLE,
        'version'       =>  '0.0.1'
    );

    public static function echo_json($array = array())
    {
        header('Content-type: application/json');

        if (isset($array['headers'])) {
            header($array['headers']);
        }

        $array = array_merge($array, self::$baseInfo);
        echo json_encode($array, JSON_PRETTY_PRINT);
    }
}
