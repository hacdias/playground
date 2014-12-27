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

        self::_route();

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

    private static function _route()
    {
        $controllerClass = "Controllers\\";

        self::$_url[1] = (isset(self::$_url[1])) ? self::$_url[1] : 'index';
        self::$_url[2] = (isset(self::$_url[2])) ? self::$_url[2] : 'index';

        switch (self::$_url[0]) {
            case 'index':
                $controllerClass .= 'index';
                break;
            case 'about':
                $controllerClass .= 'about';
                break;
            case 'api':
                $controllerClass .= 'Api\\' . self::$_url[1];
                break;
            case 'new':
            case 'add':
            default:
                $controllerClass .= 'note';
                break;
        }

        if (class_exists($controllerClass)) {

            self::$_controller = new $controllerClass();

            switch (self::$_url[0]) {
                case 'index':
                case 'about':
                case 'new':
                    self::$_controller->index();
                    break;
                case 'add':
                    self::$_controller->add();
                    break;
                case 'api':
                    self::$_controller->{self::$_url[2]}();
                    break;
                default:
                    self::$_controller->view(self::$_url[0]);
                    break;
            }

            return false;

        } else {

            self::_error();
            return false;

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
