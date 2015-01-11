<?php

namespace Helpers;

/**
 * Http Class
 *
 * This class has some useful functions to
 * use with HTTP methods such as getting
 * post elements with an associative array.
 *
 * @package     InMVC
 * @subpackage  Helpers
 * @version     0.0.5
 */
abstract class Http
{
    /**
     * Get Elements From Post
     *
     * This function receives an array with the information
     * needed and then check if this information is passed
     * by POST and then return it. Example:
     *
     * Passed array:
     *      array('info1', 'info2', 'info3);
     *
     * Returned array:
     *      array(
     *          'info1' =>  "What is found in 'info1' field of POST.",
     *          'info2' =>  "What is found in 'info2' field of POST.",
     *          'info3' =>  "What is found in 'info2' field of POST."
     *      );
     *
     * @param array $elementsToGet          Array with information to get.
     * @param bool  $returnInfoIfMissing    Do you want to return false if some information is missing?
     *
     * @return array|bool   An associative array with the obtained information OR false in case of failure.
     */
    public static function getArrayElementsFromPost($elementsToGet, $returnInfoIfMissing = false)
    {
        $data = array();

        for ($i = 0; $i < count($elementsToGet); $i++) {

            if (!isset($_POST[$elementsToGet[$i]]) && !$returnInfoIfMissing)
                return false;

            $data[$elementsToGet[$i]] = $_POST[$elementsToGet[$i]];

        }

        return $data;
    }
}
