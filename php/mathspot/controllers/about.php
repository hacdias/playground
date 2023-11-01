<?php

namespace Controller;

class About extends \Controller {

    function __construct() {
        parent::__construct('about');
    }

    function index() {
        $this->view->render('about/index');
    }

}
