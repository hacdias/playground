<?php

namespace Controller;

class Page extends \Controller
{

    function __construct()
    {
        parent::__construct('page');
    }

    function index()
    {
        $this->view->setTitle('Page');
        $this->view->render('page/index');
    }

}
