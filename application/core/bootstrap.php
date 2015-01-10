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
 * @version     0.0.5
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

        switch(self::$url[0]) {
            case 'api':
                if (!JSON_IGNORE_ROUTES)
                    self::routingExceptions();
                break;
            default:
                self::routingExceptions();
                break;
        }

        define('SEND_JSON', (self::$url[0] === 'api' && JSON_API) ? true : false);

        self::initializeController();
        self::callMethod();

        return false;
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

        $routeDefined = false;

        for ($i = 0; $i < count(self::$url); $i++) {

            self::$url[$i] = rtrim(self::$url[$i]);

            if ($routeDefined)
                break;

            for ($j = 0; $j < count($routes); $j++) {

                if ($routeDefined)
                    break;

                if ($routes[$j][0] === '#' || $routes[$j][0] === "\n")
                    continue;

                $url = explode('!', $routes[$j]);

                if (count($url) < 2)
                    continue;

                $link = rtrim($url[0]);
                $link = explode('/', $link);

                $isThisRoute = false;

                for ($k = 0; $k < count($link); $k++) {

                    if ($k === $i) {

                        if ($link[$k] === self::$url[$i]) {

                            unset(self::$url[$i]);
                            $isThisRoute = true;
                            self::$url = array_values(self::$url);

                        } elseif ($link[$k][0] === '{' && $link[$k][strlen($link[$k]) - 1] === '}') {

                            $regex = $link[$k];
                            $regex = str_replace('{', '/', $regex);
                            $regex = str_replace('}', '/', $regex);

                            if (preg_match($regex, self::$url[$i])) {
                                $isThisRoute = true;
                            }
                        }
                    }
                }

                if ($isThisRoute) {

                    $routeTo = $url[1];
                    $routeTo = explode('/', $routeTo);

                    for ($y = count($routeTo) - 1; $y >= 0; $y--) {
                        array_unshift(self::$url, $routeTo[$y]);
                    }

                    $routeDefined = true;
                }
            }
        }
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

        if (class_exists($controllerClass)) {

            self::$controller = new $controllerClass(self::$url[0]);
            return false;

        } else {

            self::error();
            return false;

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

    /**
     * Calls the Method
     *
     * This function calls the method depending on the
     * url fetched above.
     */
    private static function callMethod()
    {
        $length = count(self::$url);

        if ($length > 1) {
            if (!method_exists(self::$controller, self::$url[1])) {
                self::error();
            }
        }

        switch ($length) {
            case 5:
                //Controller->Method(Param1, Param2, Param3)
                self::$controller->{self::$url[1]}(self::$url[2], self::$url[3], self::$url[4]);
                break;

            case 4:
                //Controller->Method(Param1, Param2)
                self::$controller->{self::$url[1]}(self::$url[2], self::$url[3]);
                break;

            case 3:
                //Controller->Method(Param1, Param2)
                self::$controller->{self::$url[1]}(self::$url[2]);
                break;

            case 2:
                //Controller->Method(Param1, Param2)
                self::$controller->{self::$url[1]}();
                break;

            default:
                if (!method_exists(self::$controller, 'index')) {
                    self::error();
                }
                self::$controller->index();
                break;
        }
    }

}