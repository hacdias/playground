<?php

namespace Controllers;

use Core\Controller;
use Core\View;

class Page extends Controller
{

    function __construct()
    {
        parent::__construct('page');
    }

    function index()
    {
        View::setHeaderTag('title', 'Page');
        View::render('header');
        View::render('page/index');
        View::render('footer');
    }

}
