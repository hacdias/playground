<?php

namespace Core;

/**
 * Controller Class
 *
 * This is the base class for every controller
 * on the application.
 *
 * @package     InMVC
 * @subpackage  Core
 */
class Controller
{
    /**
     * Constructor
     *
     * The constructor of this class automatically initializes
     * the View and sets the corresponding model path. If the
     * model file exists, it calls it.
     *
     * @param string $name The name of the current Controller.
     */
    function __construct($name)
    {
        $this->view = new View();

        $path = ROOT . 'models/' . $name . '.php';

        if (file_exists($path)) {
            require $path;

            $modelName = "\\Model\\" . $name;
            $this->model = new $modelName();
        }
    }

}
