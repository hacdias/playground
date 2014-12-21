<?php

namespace Model;

use \Core\Model;

class Posts extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getPosts()
    {
        return $this->db->select("SELECT * FROM posts");
    }
}
