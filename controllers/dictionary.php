<?php

namespace Controller;

class Dictionary extends \Controller {

    function __construct() {
        parent::__construct('Dictionary');
    }

    function index() {
        $this->page();
    }

    function page($n = 1) {
        $this->view->info = $this->model->allItems($n);

        if ($this->view->info['page'] > $this->view->info['max_pages'] || $this->view->info['page'] < 0) {

            $this->view->title = '404';
            $this->view->msg = 'Ups! Nada encontrado - página errada ou então nós fizemos asneira.';

            $this->view->render('error/index');

        } else {
            $this->view->render('dictionary/index');
        }
    }

    function cat($ucategory, $n = 1) {
        $this->view->info = $this->model->category($ucategory, $n);

        if (!$this->view->info) {

            $this->view->title = '404';
            $this->view->msg = 'Ups! Nada encontrado - página errada ou então nós fizemos asneira.';

            $this->view->render('error/index');

        } else {
            $this->view->render('dictionary/index');
        }

    }

    function item($utitle) {
        $this->view->info = $this->model->item($utitle);

        if (!$this->view->info) {

            $this->view->title = '404';
            $this->view->msg = 'Ups! Nada encontrado - página errada ou então nós fizemos asneira.';

            $this->view->render('error/index');

        } else {
            $this->view->render('dictionary/index');
        }

    }

    function favorites() {
        $this->lists('favs');
    }

    function readLater() {
        $this->lists('later');
    }

    protected function lists($list) {
        global $person;

        if ($person->loggedIn()) {

            $this->view->info = $this->model->listFavLater($_SESSION['user_user'], $list);

            if ($this->view->info) {
                $this->view->render('dictionary/index');
            } else {
                $this->view->render('');
            }


        } else {
            $options = array();
            $options['needLogin'] = true;

            echo "<script> var options = eval('( " . json_encode($options) . ")'); </script>";

            $this->view->render('user/login');
        }
    }


}