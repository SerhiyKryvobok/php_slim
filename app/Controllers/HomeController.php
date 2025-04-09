<?php

namespace App\Controllers;

use App\Models\Category;

class HomeController extends BaseController
{
    public function home($request, $response, $args)
    {
        // $this->container->db::schema()->drop('categories');
        // $user = Capsule::table('users')->where('id', 1)->get();
        // return print_r($this->container->db->table('categories')->where('name', 'Electronics')->get());

        $categories = Category::all();

        $response = $this->container->view->render($response, 'view.phtml', [
            'categories' => $categories,
        ]);
        return $response;
    }
}