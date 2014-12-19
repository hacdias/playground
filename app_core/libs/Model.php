<?php

/**
 * Class Model
 *
 * @package InMVC
 */
class Model
{
    /**
     * The constructor of this class automatically initializes
     * the Database.
     */
    function __construct()
    {
        $this->db = new \Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }

}
