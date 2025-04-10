<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends BaseController
{
    public function deleteCategory($request, $response, $args)
    {
        $category_id = $args['id'];
        $category = Category::find($category_id);
        $category->delete();

        $response = $this->container->view->render($response, 'view.phtml', [
            'category_deleted' => true
        ]);
        return $response;
    }
    public function showCategory($request, $response, $args)
    {
        $category_id = $args['id']; 
        // $category_id = explode(',', $args['id']); // Not necessary because ::find method below find correct category even when "{id},{name}" string passed

        $category = Category::find($category_id);
        // $category = Category::find((int)$category_id[0]); // Not necessary as well
        $response = $this->container->view->render($response, 'view.phtml', [
            'category' => $category
        ]);
        return $response;
    }
    public function editCategory($request, $response, $args)
    {
        $category_id = $args['id'];
        // ToDo: get category by id from the database
        $category = ['name'=>'Electronics', 'parent'=>null];
        $response = $this->container->view->render($response, 'view.phtml', [
            'editedCategory' => $category
        ]);
        return $response;
    }
    public function saveCategory($request, $response, $args)
    {
        $data = $request->getParsedBody();
        if (empty($data['category-name']) || empty($data['category-description']))
            $categorySaved = false;
        else
            $categorySaved = true;
        // ToDo: save category props to the database
        $response = $this->container->view->render($response, 'view.phtml', [
            'categorySaved' => $categorySaved
        ]);
        return $response;
    }
}