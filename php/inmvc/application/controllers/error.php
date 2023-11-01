<?php

namespace Controllers;

use Core\Controller;
use Core\View;
use Helpers\Json;

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
                $data['message'] = "Internal Server Error. Probably we did something wrong.";
                break;
            case '404':
            default:
                $data['headers'] = 'HTTP/1.0 404 Not Found';
                $data['title'] = 'Error 404';
                $data['message'] = "Not found. There is nothing here.";
                break;
        }

        if (!SEND_JSON) {
            $keywords = 'error, ' . $error;

            View::setHeaderTag('title', $data['title']);
            View::setHeaderTag('keywords', $keywords);
            View::setHeaderTag('description', $data['message']);

            View::render('header', array(), $data['headers']);
            View::render('error/index', $data);
            View::render('footer');
        } else {
            Json::echoJson($data);
        }
    }

}
