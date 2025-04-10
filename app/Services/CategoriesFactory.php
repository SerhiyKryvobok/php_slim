<?php

namespace App\Services;

use App\Models\Category;

class CategoriesFactory {
    // get categories from db
    // convert result to nested array
    // convert to string

    public static function create(): string
    {
        $categories = Category::all()->toArray();

        // // Anonimous classes usecase
        // $htmlList = new class {
        //     public function convert(array $categories)
        //     {
        //         return [];
        //     }
        //     public function makeUlList(array $converted_array)
        //     {
        //         return '';
        //     }
        // };

        $htmlList = new HtmlList();

        $converted_array = $htmlList->convert($categories);
        return $htmlList->makeUlList($converted_array);
    }
}