<?php

namespace Core;

/**
* View Class
*
* This is the base class for every view
* on the application.
*
* @package     InMVC
* @subpackage  Core
*/
class View
{
    /** @var array $headerInfo The information to <head> section */
    private static $headerInfo = array();

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
    * This function is used to render a part of the page.
    *
    * @param string $name The name of the main file.
    * @param mixed $data Data to be inserted into the view.
    * @param string $headers Some headers to be sent.
    * @param boolean $forceHeaderTags Force sending the header tags.
    */
    public static function render($name, $data = array(), $headers = '', $forceHeaderTags = false)
    {
        if ($name === 'header' || $forceHeaderTags) {
            $data = self::$headerInfo;

            $data['assets'] = (isset($data['assets'])) ? View::renderAssetsCode($data['assets']) : NULL;
            $data['assets'] .= View::renderAssetsCode(unserialize(ASSETS));
        }

        if (!headers_sent()) {
            header($headers);
        }

        require DIR_VIEWS . $name . '.php';
    }

    /**
    * Set Header Tag
    *
    * This function is used to set some tag that will be used
    * in the <head> section of the page.
    *
    * @param string $name  The name that corresponds with the content.
    * @param string $content The content.
    */
    public static function setHeaderTag($name, $content)
    {
        self::$headerInfo[$name] = $content;
    }

    /**
    * Render Assets Code
    *
    * This function is used to render the assets code, ie, the
    * code to call CSS and JS assets.
    *
    * @param $arr
    * @return string
    */
    public static function renderAssetsCode($arr)
    {
        $cssModel = "<link rel='stylesheet' href='{{link}}?v={{hash}}' type='text/css' media='all'/>\n";
        $jsModel = "<script src='{{link}}?v={{hash}}'></script>\n";

        $css = isset($arr['css']) ? $arr['css'] : array();
        $js = isset($arr['js']) ? $arr['js'] : array();

        $code = '';

        for ($i = 0; $i < 2; $i++) {

            $type = ($i === 0) ? 'css' : 'js';

            foreach (${$type} as $item) {

                $file = DIR_PUBLIC . $item . '.' . $type;

                if (file_exists($file)) {
                    $link = URL . $item . '.' . $type;
                    $hash = md5(DIR_PUBLIC . $item . '.' . $type);

                    $string = str_replace('{{link}}', $link, ${$type . 'Model'});
                    $string = str_replace('{{hash}}', $hash, $string);

                    $code.= $string;
                }
            }
        }

        return $code;
    }

}
