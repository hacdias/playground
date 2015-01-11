<?php

namespace Core;

use Controllers;

/**
 * Bootstrap
 *
 * This is where everything is controlled. This file coordinates
 * decides what controller and method is called and what arguments
 * are passed from the URL to the application.
 *
 * @package     InMVC
 * @subpackage  Core
 * @version     0.0.6
 */
class Bootstrap
{
    /** @var string|null $url his variable should store the current URL. */
    private static $url = null;
    /** @var Controller|null $controller The controller of the current request. */
    private static $controller = null;

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
        self::getUrl();

        if ((self::$url[0] === 'api' && !JSON_IGNORE_ROUTES) || self::$url[0] != 'api')
            self::routingExceptions();

        define('SEND_JSON', (self::$url[0] === 'api' && JSON_API) ? true : false);

        self::initializeController();
        self::callMethod();

        return;
    }

    /**
     * Get URL
     *
     * This function get the content of 'url' variable
     * of HTTP GET method. See the .htaccess for more
     * information.
     */
    private static function getUrl()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        if (empty($url[0]))
            $url[0] = 'index';

        if ($url[0] === 'api' && JSON_API && empty($url[1]))
            $url[1] = 'index';

        self::$url = $url;
    }

    /**
     * Routes Exceptions
     *
     * Confirms if there is some router exception declared
     * into the routes file.
     */
    private static function routingExceptions()
    {
        if (!file_exists(ROOT . 'routes'))
            exit("There is no routes file.");

        $routes = file_get_contents(ROOT . 'routes');
        $routes = rtrim($routes, "\n");
        $routes = explode("\n", $routes);

        for ($i = 0; $i < count(self::$url); $i++) {

            self::$url[$i] = rtrim(self::$url[$i]);

            for ($j = 0; $j < count($routes); $j++) {

                if (empty($routes[$j]) || $routes[$j][0] === '#')
                    continue;

                $url = explode('!', $routes[$j]);

                if (count($url) < 2)
                    continue;

                $link = rtrim($url[0]);
                $link = explode('/', $link);

                $routeTo = $url[1];

                for ($k = 0; $k < count($link); $k++) {

                    if ($k === $i && $link[$k] === self::$url[$i]) {

                        self::modifyUrlWithExceptions($link, $routeTo);
                        return;

                    } elseif ($k === $i && $link[$k][0] === '{' && $link[$k][strlen($link[$k]) - 1] === '}') {

                        $regex = $link[$k];
                        $regex = str_replace('{', '/', $regex);
                        $regex = str_replace('}', '/', $regex);

                        if (preg_match($regex, self::$url[$i])) {

                            self::modifyUrlWithExceptions($link, $routeTo);
                            return;

                        }
                    }
                }
            }
        }
    }

    /**
     * Modify Url With Exceptions
     *
     * If some routing exception is detected, this function will convert
     * the current class URL variable into the new one with the correct
     * controller and method.
     *
     * @param array $itemsToRemove
     * @param array $itemsToAdd
     */
    private static function modifyUrlWithExceptions($itemsToRemove, $itemsToAdd)
    {
        $url = self::$url;

        for ($i = 0; $i < count($url); $i++) {
            for ($j = 0; $j < count($itemsToRemove); $j++) {

                if ($j === $i && $url[$i] === $itemsToRemove[$j])
                    unset($url[$i]);
            }
        }

        $url = array_values($url);
        $itemsToAdd = explode('/', $itemsToAdd);

        for ($y = count($itemsToAdd) - 1; $y >= 0; $y--) {
            array_unshift($url, $itemsToAdd[$y]);
        }

        self::$url = $url;
        return;
    }

    /**
     * Initialize the Controller
     *
     * This function initializes the controller that
     * matches with the current url.
     *
     * @return bool
     */
    private static function initializeController()
    {
        $controllerClass = "Controllers\\";

        if (self::$url[0] === 'api' && JSON_API) {
            $controllerClass .= "Api\\" . self::$url[1];
            array_shift(self::$url);
        } else {
            $controllerClass .= self::$url[0];
        }

        if (!class_exists($controllerClass))
            self::error();

        self::$controller = new $controllerClass(self::$url[0]);
        return;
    }

    /**
     * Calls the Method
     *
     * This function calls the method depending on the
     * url fetched above.
     */
    private static function callMethod()
    {
        $length = count(self::$url);
        $method = isset(self::$url[1]) ? self::$url[1] : 'index';

        for ($i= 1; $i < count(self::$url); $i++) {
            if ($i != 1)
                ${'param' . ($i - 1)} = self::$url[$i];
        }

        if (!method_exists(self::$controller, $method))
            self::error();

        switch ($length) {
            case 5:
                //Controller->Method(Param1, Param2, Param3)
                self::$controller->{$method}($param1, $param2, $param3);
                break;

            case 4:
                //Controller->Method(Param1, Param2)
                self::$controller->{$method}($param1, $param2);
                break;

            case 3:
                //Controller->Method(Param1, Param2)
                self::$controller->{$method}($param1);
                break;

            case 2:
            default:
                //Controller->Method(Param1, Param2)
                self::$controller->{$method}();
                break;
        }
    }

    /**
     * Error
     *
     * Display an error page if there's no controller
     * that corresponds with the current url.
     */
    private static function error()
    {
        $error = (self::$url[0] == '500') ? '500' : '404';

        self::$controller = new Controllers\Error();
        self::$controller->index($error);

        exit;
    }

}