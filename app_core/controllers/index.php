<?php

namespace Controller;

class Index extends \Controller
{

    function __construct()
    {
        parent::__construct('index');
    }

    function index()
    {
        $this->view->setTitle('Home');
        $this->view->render('index/index');
    }

}
