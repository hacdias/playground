<?php

namespace Controller;

class Error extends \Controller {

    function __construct() {
        parent::__construct('error');
    }

    function index() {
        $this->view->title = '404';
        $this->view->msg = 'Ups! Nada encontrado - página errada ou então nós fizemos asneira.';

        $this->view->render('error/index');
    }

}