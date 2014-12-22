<?php

namespace Controllers;

use \Core\Controller;
use \Core\View;

class Index extends Controller
{
    function __construct()
    {
        parent::__construct('index');
    }

    function index()
    {
        View::setHeaderTag('title', 'Home');

        View::render('header');
        View::render('index/index');
        View::render('footer');
    }

}
