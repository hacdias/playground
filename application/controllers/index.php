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
        View::render('index/index', array(), '', true);
    }

}
