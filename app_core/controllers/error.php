<?php

namespace Controller;

class Error extends \Controller
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

        $this->view->setTitle($data['title']);
        $this->view->setData($data);
        $this->view->render('error/index');
    }

}
