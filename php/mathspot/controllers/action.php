<?php

namespace Controller;

class Action extends \Controller {

    function __construct() {
        parent::__construct('Action');
    }

    function logout() {
        global $person;

        if ($person->logout()) {

            $result['status'] = 0;

            ob_end_clean();
            header('Content-type: application/json');
            echo json_encode($result);
        }
    }

    function login() {
        global $person;

        $user = isset($_POST['user']) ? $_POST['user'] : null;
        $pass = isset($_POST['pass']) ? $_POST['pass'] : null;

        $remember = (isset($_POST['remember']) AND !empty($_POST['remember']));

        $person->login($user, $pass, $remember);
    }

    function register() {
        global $person;
        $name = isset($_POST['name']) ? $_POST['name'] : null;
        $user = isset($_POST['user']) ? $_POST['user'] : null;
        $pass = isset($_POST['password']) ? $_POST['password'] : null;

        $person->registration($name, $user, $pass);
    }

    function update_conf() {
        $user = isset($_POST['user']) ? $_POST['user'] : null;
        $color = isset($_POST['color']) ? $_POST['color'] : null;
        $bio = isset($_POST['bio']) ? $_POST['bio'] : null;

        \Person::configUpdate($user, $color, $bio);
    }

    function addFav() {
        $this->actionItem('favs', 'add');
    }

    function addLater() {
        $this->actionItem('later', 'add');
    }

    function remFav() {
        $this->actionItem('favs', 'rem');
    }

    function remLater() {
        $this->actionItem('later', 'rem');
    }

    protected function actionItem($list, $action) {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $user = isset($_POST['user']) ? $_POST['user'] : null;

        $this->model->actionFavLater($id, $user, $list, $action);
    }

}