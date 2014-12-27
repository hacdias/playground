<?php

namespace Core;

use \Controllers;

/**
 * Bootstrap
 *
 * This is where everything is controlled. This file coordinates
 * decides what controller and method is called and what arguments
 * are passed from the URL to the application.
 *
 * @package     InMVC
 * @subpackage  Core
 */
class Bootstrap
{
    /** @var string|null $_url his variable should store the current URL. */
    private static $_url = null;
    /** @var Controller|null $_controller The controller of the current request. */
    private static $_controller = null;

    /**
     * Starts the Bootstrap
     *
     * This function is used to initialize the application
     * and call the other main functions.
     *
     * @return boolean
     */
    public static function init()
    {
        self::_getUrl();

        if (empty(self::$_url[0])) {
            self::$_url[0] = 'index';
        }

        define('SEND_JSON', (self::$_url[0] === 'api') ? true : false);

        self::_controller();
        self::_method();

        return false;
    }

    /**
     * Get URL
     *
     * This function get the content of 'url' variable
     * of HTTP GET method. See the .htaccess for more
     * information.
     */
    private static function _getUrl()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        self::$_url = explode('/', $url);
    }

    /**
     * Initialize the Controller
     *
     * This function initializes the controller that
     * matches with the current url.
     *
     * @return bool
     */
    private static function _controller()
    {
        $controllerClass = "Controllers\\" . self::$_url[0];

        if (class_exists($controllerClass)) {

            self::$_controller = new $controllerClass(self::$_url[0]);
            return false;

        } else {

            self::_error();
            return false;

        }
    }

    /**
     * Calls the Method
     *
     * This function calls the method depending on the
     * url fetched above.
     */
    private static function _method()
    {
        $length = count(self::$_url);

        if ($length > 1) {
            if (!method_exists(self::$_controller, self::$_url[1])) {
                self::_error();
            }
        }

        switch ($length) {
            case 5:
                //Controller->Method(Param1, Param2, Param3)
                self::$_controller->{self::$_url[1]}(self::$_url[2], self::$_url[3], self::$_url[4]);
                break;

            case 4:
                //Controller->Method(Param1, Param2)
                self::$_controller->{self::$_url[1]}(self::$_url[2], self::$_url[3]);
                break;

            case 3:
                //Controller->Method(Param1, Param2)
                self::$_controller->{self::$_url[1]}(self::$_url[2]);
                break;

            case 2:
                //Controller->Method(Param1, Param2)
                self::$_controller->{self::$_url[1]}();
                break;

            default:
                self::$_controller->index();
                break;
        }
    }

    /**
     * Error
     *
     * Display an error page if there's no controller
     * that corresponds with the current url.
     */
    private static function _error()
    {
        $error = (self::$_url[0] == '500') ? '500' : '404';

        self::$_controller = new Controllers\Error();
        self::$_controller->index($error);

        exit;
    }

}
