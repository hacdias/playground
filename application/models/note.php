<?php

namespace Model;

use \Core\Model;

class Note extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function confirm($id)
    {
        $data = $this->db->select("SELECT id FROM notes WHERE id ='" . $id . "' LIMIT 1;");
        return (empty($data)) ? false : true;
    }

}
