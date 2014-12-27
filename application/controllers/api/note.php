<?php

namespace Controllers\Api;

use \Core\Controller;
use \Core\View;

class Note extends Controller
{
    function __construct()
    {
        parent::__construct('Api\\Note');
    }

    function index()
    {
        //Index Function
    }

    function add()
    {
        $data = array(
            'content'   =>  isset($_POST['content']) ? $_POST['content'] : NULL,
            'password'  =>  isset($_POST['password']) ? $_POST['password'] : NULL,
            'iv'        =>  isset($_POST['iv']) ? $_POST['iv'] : NULL);

        $result = $this->model->addNote($data);
        Note::echo_json($result);
    }

    function view($id = NULL)
    {
        $note = $this->model->getContent($_POST['id'], $_POST['password']);
        Note::echo_json($note);
    }

    public static function echo_json($array)
    {
        header('Content-type: application/json');
        echo json_encode($array);
    }

}
