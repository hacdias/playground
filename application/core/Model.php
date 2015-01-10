<?php

namespace Core;

use Helpers\Database as Database;

/**
 * Model Class
 *
 * This is the base class for every model
 * on the application.
 *
 * @package     InMVC
 * @subpackage  Core
 * @version     0.0.5
 */
abstract class Model
{
    /**
     * Construct
     *
     * The constructor of this class automatically initializes
     * the Database.
     */
    function __construct()
    {
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }

}
