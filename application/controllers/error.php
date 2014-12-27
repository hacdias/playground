<?php

namespace Controllers;

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
            case '500':
                $data['headers'] = 'HTTP/1.0 500 Internal Server Error';
                $data['title'] = 'Error 500';
                $data['msg'] = "Internal Server Error. Probably we did something wrong.";
                break;
            case '404':
            default:
                $data['headers'] = 'HTTP/1.0 404 Not Found';
                $data['title'] = 'Error 404';
                $data['msg'] = "Not found. There is nothing here.";
                break;

        }

        $keywords = 'error, ' . $error;

        View::setHeaderTag('title', $data['title']);
        View::setHeaderTag('keywords', $keywords);
        View::setHeaderTag('description', $data['msg']);

        View::render('header', array(), $data['headers']);
        View::render('error/index', $data);
        View::render('footer');
    }

}
