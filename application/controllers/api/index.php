<?php

namespace Controllers\Api;

use Core\Controller;
use Helpers\Json;

class Index extends Controller
{
    function __construct()
    {
        parent::__construct('Api\\Index');
    }

    function index()
    {
        $content = array(
            'title' => 'This is the API Index'
        );
        Json::echoJson($content);
    }
}