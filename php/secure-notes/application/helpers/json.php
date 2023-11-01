<?php

namespace Helpers;

/**
 * Json Class
 *
 * Some useful function to use with Json.
 *
 * @package     InMVC
 * @subpackage  Helpers
 * @version     0.0.5
 */
abstract class Json
{
    /** @var mixed $baseInfo Some info to be sent in every json request. */
    private static $baseInfo = array(
        'application' => SITE_TITLE,
        'version' => '0.0.5'
    );

    public static function echoJson($array = array())
    {
        header('Content-type: application/json');

        if (isset($array['headers'])) {
            header($array['headers']);
        }

        $array = array_merge($array, self::$baseInfo);
        echo json_encode($array, JSON_PRETTY_PRINT);
    }
}
