<?php

namespace App\Services;

class HtmlList extends CategoryTree {

    public $html_1 = '<ul>';
    public $html_2 = '<li>';
    public $html_3 = '</li>';
    public $html_4 = '</ul>';

    public function makeUlList(array $converted_db_array): string
    {
        $this->categoryList .= $this->html_1;
        foreach ($converted_db_array as $value) {
            $this->categoryList .= $this->html_2 . $value['name'];
            if (!empty($value['children']))
            {
                $this->makeUlList($value['children']);
            }
            $this->categoryList .= $this->html_3;
        }
        $this->categoryList .= $this->html_4;

        return $this->categoryList;
    }
}