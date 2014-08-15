<?php

namespace Controller;

class User extends \Controller {

    function __construct() {
        parent::__construct('user');
    }

    function login() {
        global $person;

        if (!$person->loggedIn()) {
            $this->view->render('user/login');
        } else {
            $this->view->title = '404';
            $this->view->msg = 'Ups! Nada encontrado - página errada ou então nós fizemos asneira.';

            $this->view->render('error/index');
        }

    }

    function register() {
        global $person;

        if ($person->loggedIn() === false) {
            $this->view->render('user/register');
        } else {
            $this->view->title = '404';
            $this->view->msg = 'Ups! Nada encontrado - página errada ou então nós fizemos asneira.';

            $this->view->render('error/index');
        }
    }

    function config() {
        global $person;

        if ($person->loggedIn()) {

            $this->view->info = $this->model->config($_SESSION['user_user']);
            $this->view->render('user/config');

        } else {
            $options = array();
            $options['needLogin'] = true;

            echo "<script> var options = eval('( " . json_encode($options) . ")'); </script>";

            $this->view->render('user/login');
        }
    }

    function profile($user) {

        $this->view->info = $this->model->profile($user);
        $this->view->info['user'] = $user;

        if (!$this->view->info) {

            $this->view->title = '404';
            $this->view->msg = 'Ups! Nada encontrado - página errada ou então nós fizemos asneira.';

            $this->view->render('error/index');

        } else {

            $this->view->render('user/profile');

        }
    }
}