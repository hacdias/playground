<?php

/**
 * Class View
 *
 * @package MVC PHP Bootstrap
 */
class View
{
    protected $_data;
    protected $_pageInfo;

    function __construct()
    {
        //Views Contruct
    }

    public function render($name)
    {
        require DIR_VIEWS . 'header.php';
        require DIR_VIEWS . $name . '.php';
        require DIR_VIEWS . 'footer.php';

    }

    public function setData($data)
    {
        $this->_data = $data;
    }

    public function setTitle($title)
    {
        $this->_pageInfo['title'] = $title . ' | ' . SITE_TITLE;
    }

}
