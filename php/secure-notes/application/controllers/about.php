<?php

namespace Controllers;

use Core\Controller;
use Core\View;

class About extends Controller
{
    function __construct()
    {
        parent::__construct('about');
    }

    function index()
    {
        View::setHeadertag('title', 'About');

        View::render('header');
        View::render('about/index');
        View::render('footer');
    }

}
