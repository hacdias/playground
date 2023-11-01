<?php
/**
 * Created by PhpStorm.
 * User: Henrique
 * Date: 16-08-2014
 * Time: 18:11
 */

namespace Controller;


class Admin extends \Controller {

    function __construct() {
        parent::__construct('admin');
    }

    function index() {
        global $person;

        if($person->loggedIn() && \Person::isAdmin($_SESSION['user_user'])) {
            $this->view->render('index/index');
        } else {
            $this->view->render('error/404');
        }
    }

} 