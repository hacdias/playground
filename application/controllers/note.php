<?php

namespace Controllers;

use \Core\Controller;
use \Core\View;

class Note extends Controller
{
    function __construct()
    {
        parent::__construct('note');
    }

    function index()
    {
        View::setHeaderTag('title', 'New Note');

        View::render('header');
        View::render('note/index');
        View::render('footer');
    }

    function view($id = NULL)
    {
        if (isset($_POST['password'])) {

            $note = $this->model->getContent($_POST['id'], $_POST['password']);

            echo json_encode($note);

        } else {

            if ($this->model->confirm($id)) {
                View::setHeaderTag('title', 'View Note');

                View::render('header');
                View::render('note/view');
                View::render('footer');
            } else {
                $error = new \Controllers\Error;
                $error->index('404');
            }

        }
    }

}
