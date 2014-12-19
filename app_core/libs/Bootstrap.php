<?php

/**
 * Class Bootstrap
 *
 * @package InMVC
 */
class Bootstrap
{
    private $_url = null;
    private $_controller = null;

    private $_errorFile = 'error.php';

    /**
     * Starts the Bootstrap
     *
     * @return boolean
     */
    public function init()
    {
        $this->_getUrl();

        if (empty($this->_url[0])) {
            $this->_url[0] = 'index';
        }

        $this->_controller();
        $this->_method();

        return false;
    }

    /**
     * This function get the content of 'url' variable
     * of HTTP GET method. See the .htaccess for more
     * information.
     */
    private function _getUrl()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $this->_url = explode('/', $url);
    }

    /**
     * This function initializes the controller that
     * matches with the current url.
     *
     * @return bool
     */
    private function _controller()
    {
        $file = DIR_CONTROLLERS . $this->_url[0] . '.php';

        if (file_exists($file)) {
            require $file;

            $controller = "Controller\\" . $this->_url[0];

            $this->_controller = new $controller($this->_url[0]);

            return false;
        } else {
            $this->_error();
            return false;
        }

    }

    /**
     * This function calls the method depending on the
     * url fetched above.
     */
    private function _method()
    {
        $length = count($this->_url);

        if ($length > 1) {
            if (!method_exists($this->_controller, $this->_url[1])) {
                $this->_error();
            }
        }

        switch ($length) {
            case 5:
                //Controller->Method(Param1, Param2, Param3)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3], $this->_url[4]);
                break;

            case 4:
                //Controller->Method(Param1, Param2)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3]);
                break;

            case 3:
                //Controller->Method(Param1, Param2)
                $this->_controller->{$this->_url[1]}($this->_url[2]);
                break;

            case 2:
                //Controller->Method(Param1, Param2)
                $this->_controller->{$this->_url[1]}();
                break;

            default:
                $this->_controller->index();
                break;
        }
    }

    /**
     * Display an error page if there's no controller
     * that corresponds with the current url.
     */
    private function _error()
    {
        require DIR_CONTROLLERS . $this->_errorFile;

        $error = ($this->_url[0] == '500') ? '500' : '404';

        $this->_controller = new Controller\Error();
        $this->_controller->index($error);

        exit;
    }

}
