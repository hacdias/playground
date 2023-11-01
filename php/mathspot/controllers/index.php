<?php

namespace Controller;

class Index extends \Controller {

    function __construct() {
        parent::__construct('index');
    }

    function index() {
        global $person;

        if (!$person->loggedIn()) {

            $this->view->render('index/index');

        } else {

            $this->view->render('index/index.user');

        }

    }

}