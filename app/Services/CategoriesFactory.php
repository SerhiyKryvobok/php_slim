<?php

namespace App\Services;

class CategoriesFactory {
    // get categories from db
    // convert result to nested array
    // convert to string

    public static function create(): string
    {
        $categories = new \stdClass();
        $categories = $categories->getCategories();
        $htmlList = new \stdClass();
        $converted_array = $htmlList->convert($categories);
        return $htmlList->makeUlList($converted_array);
    }
}