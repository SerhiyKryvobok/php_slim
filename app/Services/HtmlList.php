<?php

namespace App\Services;

class HtmlList extends CategoryTree {

    public function makeUlList(array $converted_db_array): string
    {
        foreach ($converted_db_array as $value) {
            $this->categoryList .= '<li><a href="http://udemy-phpunit-slim.loc/show-category/' . $value['id'] . ',' . $value['name'] . '">' . $value['name'] . '</a>';
            if (!empty($value['children']))
            {
                $this->categoryList .= '<ul class="submenu menu vertical" data-submenu>';
                $this->makeUlList($value['children']);
                $this->categoryList .= '</ul>';
            }
            $this->categoryList .= '</li>';
        }

        return $this->categoryList;
    }
}