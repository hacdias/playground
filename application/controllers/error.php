<?php

namespace Controller;

use \Core\Controller;
use \Core\View;

class Error extends Controller
{
    function __construct()
    {
        parent::__construct('error');
    }

    function index($error = '404')
    {
        $data = array();

        switch ($error) {
            case '404':
                $data['title'] = 'Error 404';
                $data['msg'] = "Not found. There is nothing here.";
                break;
            case '500':
            default:
                $data['title'] = 'Error 500';
                $data['msg'] = "Internal Server Error. Probably we did something wrong.";
                break;
        }

        $keywords = 'error, ' . $error;

        View::setHeaderTag('title', $data['title']);
        View::setHeaderTag('keywords', $keywords);
        View::setHeaderTag('description', $data['msg']);

        View::render('header');
        View::render('error/index', $data);
        View::render('footer');
    }

}
