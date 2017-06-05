<?php

namespace Core\Custom;

use Core\Basics\Request;
use Core\Basics\Session;
use Core\Basics\View;

/**
 * Class AbstractController
 *
 * @author Adrien PAYEN <adrien.payen2@gmail.com>
 */
class Controller
{
    protected $request;
    protected $session;

    public function __construct()
    {
        $this->request = Request::getInstance();
        $this->session = Session::getInstance();
        $this->session->start();
    }

    protected function render($file, $data=[])
    {
        $view = new View();
        return $view->render($file, $data);
    }

    protected function redirect($path)
    {
        return $this->request->redirect($path);
    }
}