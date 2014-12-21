<?php

namespace Controller;

use \Core\Controller;

class Posts extends Controller
{

    function __construct()
    {
        parent::__construct('posts');
    }

    function index()
    {
        $data = $this->model->getPosts();
        $this->view->setData($data);
        $this->view->setTitle('Posts');

        $this->view->render('posts/index');
    }

}
