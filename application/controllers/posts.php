<?php

namespace Controllers;

use Core\Controller;
use Core\View;

class Posts extends Controller
{

    function __construct()
    {
        parent::__construct('posts');
    }

    function index()
    {
        $data = $this->model->getPosts();

        View::setHeaderTag('title', 'Posts');
        View::render('header');
        View::render('posts/index', $data);
        View::render('footer');
    }

}
