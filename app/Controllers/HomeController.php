<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function home($request, $response, $args)
    {
        // $data = $request->getQueryParams(); // GET data like ?param=something
        // $data = $request->getParsedData(); // POST data
        $response->getBody()->write($this->container->my_service);
        $response->getBody()->write($this->container['settings']['db']['user']);
        $data = [
            ['name' => 'Adam', 'id' => 1],
            ['name' => 'John', 'id' => 2],
        ];
        $response = $this->container->view->render($response, 'view.phtml', ['name' => $args['name'], 'data' => $data]);
        return $response;
    }
}