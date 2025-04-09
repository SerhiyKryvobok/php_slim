<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function home($request, $response, $args)
    {
        // $this->container->db::schema()->drop('categories');
        // $user = Capsule::table('users')->where('id', 1)->get();
        // return print_r($this->container->db->table('categories')->where('name', 'Electronics')->get());

        $response = $this->container->view->render($response, 'view.phtml');
        return $response;
    }
}