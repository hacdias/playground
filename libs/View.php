<?php

class View {

    protected $_cssHash;
    protected $_jsHash;

    function __construct() {
        //echo 'this is the view';
    }

    public function render($name /* , $noInclude = false */) {
        define('LOAD', isset($_GET['load']) ? $_GET['load'] : 'all');

        if (LOAD === 'all') {

            $this->_cssHash = md5_file(ROOT . DS . 'public' . DS . 'css' . DS . 'template.css');
            $this->_jsHash = md5_file(ROOT . DS . 'public' . DS . 'js' . DS . 'page.js');

            require ROOT . 'views/header.php';
        }

        require ROOT . 'views/' . $name . '.php';

        if (LOAD === 'all') {
            require ROOT . 'views/footer.php';
            require ROOT . 'views/sidebar.php';
        }
    }

}