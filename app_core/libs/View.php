<?php

/**
 * View Class
 *
 * This is the base class for every view
 * on the application.
 *
 * @package     InMVC
 * @subpackage  Library
 */
class View
{
    /** @var array $_data An array with the data to be used in HTML view. */
    protected $_data;
    /** @var array $_pageInfo An array with the main information of the page. */
    protected $_pageInfo;
    /** @var array $_pageMeta An array with the meta information of the page. */
    protected $_pageMeta;

    /**
     * Constructor
     *
     * This constructor is empty.
     */
    public function __construct()
    {
        //Views Constructor
    }

    /**
     * Render
     *
     * This function is used to render the page. The header,
     * the main content and the footer are called here.
     *
     * @param string $name The name of the main file.
     */
    public function render($name)
    {
        require DIR_VIEWS . 'header.php';
        require DIR_VIEWS . $name . '.php';
        require DIR_VIEWS . 'footer.php';

    }

    /**
     * Set Data
     *
     * This function is used to set the $_data variable.
     *
     * @param array $data The data that will be shown on the front-end.
     */
    public function setData($data)
    {
        $this->_data = $data;
    }

    /**
     * Set Title
     *
     * This function is used to set the title of the page.
     *
     * @param $title
     */
    public function setTitle($title)
    {
        $this->_pageInfo['title'] = $title . ' | ' . SITE_TITLE;
    }

    /**
     * Set Meta Tags content
     *
     * This function is used to set the content of the meta
     * tags that are placed in the page header.
     *
     * @param array $meta An array with the information.
     */
    public function setMetaTags($meta = array())
    {
        $meta['description'] = isset($meta['description']) ? $meta['description'] : '';
        $meta['keywords'] = isset($meta['keywords']) ? $meta['keywords'] : '';

        $this->_pageMeta = $meta;
    }

    /**
     * Print Assets
     *
     * This function is used to print the assets calls like
     * css and js  in the page header.
     *
     * @param array $arr The array with the assets locations
     */
    protected function printAssets($arr)
    {
        $css = $arr['css'];
        $js = $arr['js'];

        $this->printAssetsHelper('css', $css);
        $this->printAssetsHelper('js', $js);
    }

    /**
     * Print Assets Helper
     *
     * This helper is used to print the assets calls
     * from the function above.
     *
     * @param string $type The type of the assets (css or js)
     * @param array $arr The array with the paths to assets
     */
    private function printAssetsHelper($type, $arr)
    {
        $cssModel = "<link rel='stylesheet' href='%s?v=%s' type='text/css' media='all'/>\n";
        $jsModel = "<script src='%s?v=%s'></script>\n";

        foreach ($arr as $item) {

            $link = URL . $item . '.' . $type;
            $hash = md5(DIR_PUBLIC . $item . '.' . $type);

            printf(${$type . 'Model'}, $link, $hash);
        }
    }

}
