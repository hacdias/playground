<?php

namespace Controller;

class Learn extends \Controller {

    function __construct() {
        parent::__construct('about');
    }

    function index() {
        $this->view->render('learn/index');
    }

} 