<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function home($request, $response, $args)
    {
        $response = $this->container->view->render($response, 'view.phtml');
        return $response;
    }
}