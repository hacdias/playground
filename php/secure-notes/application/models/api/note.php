<?php

namespace Model\Api;

if (version_compare(phpversion(), '5.5.0', '<')) {
    require ROOT . 'lib/password.php';
}

use Core\Model;

class Note extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    function addNote($arr)
    {
        $data = array(
            'content' => $arr['content'],
            'password' => password_hash($arr['password'], PASSWORD_BCRYPT),
            'iv' => $arr['iv']
        );

        $this->db->insert('notes', $data);

        $sth = $this->db->select("SELECT id FROM notes WHERE password ='" . $data['password'] . "' LIMIT 1");

        foreach ($sth as $row) {
            $id = $row['id'];
        }

        $result = array(
            'url' => URL . $id
        );

        return $result;
    }

    function getContent($id = NULL, $password = NULL)
    {
        $query = $this->db->select("SELECT * FROM notes WHERE id = " . $id . " LIMIT 1;");

        $result = array(
            'status' => false
        );

        foreach ($query as $note) {

            if (password_verify($password, $note['password'])) {
                $result = array(
                    'status' => true,
                    'content' => $note['content'],
                    'iv' => $note['iv']
                );
            }

        }

        return $result;
    }

}
