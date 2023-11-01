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

    function favorites($n = 1) {
        $this->lists('favs', $n);
    }

    function readLater($n = 1) {
        $this->lists('later', $n);
    }

    protected function lists($list, $n = 1) {
        global $person;

        if ($person->loggedIn()) {

            $this->view->info = $this->model->listFavLater($_SESSION['user_user'], $list, $n);

            if ($this->view->info) {
                $this->view->render('dictionary/index');
            } else {
                $this->view->render('dictionary/no-items');
            }


        } else {
            $options = array();
            $options['needLogin'] = true;

            echo "<script> var options = eval('( " . json_encode($options) . ")'); </script>";

            $this->view->render('user/login');
        }
    }


}