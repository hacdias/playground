<?php

namespace Controller;

class Sidebar extends \Controller {

    function __construct() {
        parent::__construct('sidebar');
    }

    function index() {
        $this->view->render('sidebar');
    }

}