<?php

namespace Core;

use Helpers\Dir as Dir;

/**
 * Controller Class
 *
 * This is the base class for every controller
 * on the application.
 *
 * @package     InMVC
 * @subpackage  Core
 * @version     0.0.5
 */
abstract class Controller
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

        $path = Dir::preparePath(ROOT . 'models/' . $name . '.php');

        if (file_exists($path)) {
            require $path;

            $modelName = "\\Model\\" . $name;
            $this->model = new $modelName();
        }
    }

}
