<?php

namespace Helpers;

/**
 * Dir Class
 *
 * This class has some useful functions to
 * prepare directories, etc.
 *
 * @package     InMVC
 * @subpackage  Helpers
 */
abstract class Dir
{
    /**
     * Prepare Path
     *
     * This function is used to prepare the path
     * to be used, ie, removes the "\" and replaces it
     * with "/" and put everything to lowercase.
     *
     * @param string $path The path to be treated.
     * @return string The path treated.
     */
    public static function preparePath($path) {
        return strtolower(str_replace("\\", "/", $path));
    }
}
