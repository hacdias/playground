<?php

namespace Controllers\Api;

use Core\Controller;
use Helpers\Json;

class Note extends Controller
{
    function __construct()
    {
        parent::__construct('Api\\Note');
    }

    function index()
    {
        Json::echoJson();
    }

    function add()
    {
        $data = array(
            'content' => isset($_POST['content']) ? $_POST['content'] : NULL,
            'password' => isset($_POST['password']) ? $_POST['password'] : NULL,
            'iv' => isset($_POST['iv']) ? $_POST['iv'] : NULL);

        $result = $this->model->addNote($data);
        Json::echoJson($result);
    }

    function view()
    {
        $note = $this->model->getContent($_POST['id'], $_POST['password']);
        Json::echoJson($note);
    }

}
