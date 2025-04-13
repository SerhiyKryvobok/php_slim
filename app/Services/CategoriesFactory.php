<?php

namespace App\Services;

use App\Models\Category;

class CategoriesFactory {
    // get categories from db
    // convert result to nested array
    // convert to string

    public static function create(): array
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
        $selectList = new ForSelectList();

        $converted_array = $htmlList->convert($categories);
        return [
            'menu_categories' => $htmlList->makeUlList($converted_array),
            'select_list_categories' => $selectList->makeSelectList($converted_array),
        ];
    }
}