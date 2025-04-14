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

        $_SESSION['category_deleted'] = true;

        return $response->withRedirect('/', 301);
    }
    public function showCategory($request, $response, $args)
    {
        // $category_id = $args['id']; 
        $category_id = explode(',', $args['id']); // Not necessary because ::find method below find correct category even when "{id},{name}" string passed

        // $category = Category::find($category_id);
        $category = Category::find((int)$category_id[0]); // Not necessary as well
        $response = $this->container->view->render($response, 'view.phtml', [
            'category' => $category
        ]);
        return $response;
    }
    public function editCategory($request, $response, $args)
    {
        $category_id = $args['id'];
        $category = Category::find($category_id);
        $response = $this->container->view->render($response, 'view.phtml', [
            'editedCategory' => $category
        ]);
        return $response;
    }
    public function saveCategory($request, $response, $args)
    {
        $_SESSION['category_saved'] = false;

        $data = $request->getParsedBody();
        if (empty($data['category-name']) || empty($data['category-description'])) {
            $categorySaved = false;
        }
        else {
            if (isset($data['category_id'])) {
                $category = Category::find($data['category_id']);
            } 
            else {
                $category = new Category;
            }
            $category->name = $data['category-name'];
            $category->description = $data['category-description'];
            $category->parent_id = $data['category-parent'] == '' ? null : $data['category-parent'];
            $category->save();

            $categorySaved = true;
            $_SESSION['category_saved'] = true;
        } 

        $response = $this->container->view->render($response, 'view.phtml', [
            'categorySaved' => $categorySaved,
        ]);

        /* if ($categorySaved) return $response->withRedirect('/', 303);
        else */ return $response;
    }
}