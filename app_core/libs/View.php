<?php

/**
 * Class View
 *
 * @package InMVC
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

    public function printAssets($arr)
    {
        $css = $arr['css'];
        $js = $arr['js'];

        $this->printAssetsHelper('css', $css);
        $this->printAssetsHelper('js', $js);
    }

    protected function printAssetsHelper($type, $arr)
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
