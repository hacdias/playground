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

    /**
     * Echo Json
     *
     * This function is used to print JSON to the page with both a predefined
     * information and another array of information.
     *
     * @param array $data Data to be sent in JSON format.
     */
    public static function echoJson($data = array())
    {
        header('Content-type: application/json');

        if (isset($data['headers'])) {
            header($data['headers']);
        }

        $array = array_merge($data, self::$baseInfo);
        echo json_encode($array, JSON_PRETTY_PRINT);
    }
}
