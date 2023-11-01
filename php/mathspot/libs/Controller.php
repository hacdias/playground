<?php

class Controller {

    function __construct($name) {
        $this->view = new \View();

        $path = ROOT . 'models/' . $name . '.php';

        if (file_exists($path)) {
            require $path;

            $modelName = "\\Model\\" . $name;
            $this->model = new $modelName();
        }
    }

}