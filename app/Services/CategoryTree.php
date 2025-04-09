<?php

namespace App\Services;

class CategoryTree {

    public function convert(array $db_array, int $parent_id = null): array
    {
        $nested_categories = array();

        foreach ($db_array as $k=>$category) {
            $category['children'] = [];
            if ($category['parent_id'] == $parent_id)
            {
                $key_of_child = $k;
                $key_of_parent = array_search($parent_id, array_column($db_array, 'id'));
                // $db_array[$key_of_child]['children'] = [];
                // $nested_categories[$key_of_parent]['children'][] = $db_array[$key_of_child];
                $nested_categories[$key_of_parent]['children'][] = $category;
            }
            else
            $nested_categories[] = $category;
        }

        return $nested_categories;
    }
}