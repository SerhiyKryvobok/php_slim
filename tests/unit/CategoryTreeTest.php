<?php

use App\Services\HtmlList;
use App\Services\CategoryTree;
use App\Services\ForSelectList;

class CategoryTreeTest extends PHPUnit\Framework\TestCase {

    protected $category_tree;

    public function setUp(): void
    {
        $this->category_tree = new CategoryTree();
    }

    /**
     * @dataProvider arrayProvider
     */
    public function testCanConvertDatabaseResultToCategoryNestedArray($after_conversion, $db_result)
    {
        $this->assertEquals($after_conversion, $this->category_tree->convert($db_result));
    }

    /**
     * @dataProvider arrayProvider
     */
    public function testCanProduceHtmlNestedCategories(array $after_conversion, array $db_result, string $html_list, array $html_select_list)
    {
        $html = new HtmlList();
        $html_select = new ForSelectList();
        $after_conversion_db = $html->convert($db_result);
        $this->assertEquals($html_list, $html->makeUlList($after_conversion_db));
        $this->assertEquals($html_select_list, $html_select->makeSelectList($after_conversion_db));
    }

    public function arrayProvider(): array
    {
        return [
            'one level' => [
                [
                    ['id'=>1, 'name'=>'Electronics', 'parent_id'=>null, 'children'=>[]],
                    ['id'=>2, 'name'=>'Videos', 'parent_id'=>null, 'children'=>[]],
                    ['id'=>3, 'name'=>'Software', 'parent_id'=>null, 'children'=>[]],
                ],
                [
                    ['id'=>1, 'name'=>'Electronics', 'parent_id'=>null],
                    ['id'=>2, 'name'=>'Videos', 'parent_id'=>null],
                    ['id'=>3, 'name'=>'Software', 'parent_id'=>null],
                ],
                '<li><a href="http://udemy-phpunit-slim.loc/show-category/1,Electronics">Electronics</a></li><li><a href="http://udemy-phpunit-slim.loc/show-category/2,Videos">Videos</a></li><li><a href="http://udemy-phpunit-slim.loc/show-category/3,Software">Software</a></li>',
                [
                    ['name'=>'Electronics', 'id'=>1],
                    ['name'=>'Videos', 'id'=>2],
                    ['name'=>'Software', 'id'=>3],
                ]
            ],
            'two level' => [
                [
                    [
                        'id'=>1,
                        'name'=>'Electronics',
                        'parent_id'=>null,
                        'children'=>[
                            [
                                'id'=>2,
                                'name'=>'Computers',
                                'parent_id'=>1,
                                'children'=>[]
                            ],
                        ]
                    ],
                ],
                [
                    ['id'=>1, 'name'=>'Electronics', 'parent_id'=>null],
                    ['id'=>2, 'name'=>'Computers', 'parent_id'=>1],
                ],
                '<li><a href="http://udemy-phpunit-slim.loc/show-category/1,Electronics">Electronics</a><ul class="submenu menu vertical" data-submenu><li><a href="http://udemy-phpunit-slim.loc/show-category/2,Computers">Computers</a></li></ul></li>',
                [
                    ['name'=>'Electronics', 'id'=>1],
                    ['name'=>'&nbsp;&nbsp;Computers', 'id'=>2],
                ]
            ],
            'three level' => [
                [
                    [
                        'id'=>1,
                        'name'=>'Electronics',
                        'parent_id'=>null,
                        'children'=>[
                            [
                                'id'=>2,
                                'name'=>'Computers',
                                'parent_id'=>1,
                                'children'=>[
                                    [
                                        'id'=>3,
                                        'name'=>'Laptops',
                                        'parent_id'=>2,
                                        'children'=>[]
                                    ]
                                ]
                            ],
                        ]
                    ]
                ],
                [
                    ['id'=>1, 'name'=>'Electronics', 'parent_id'=>null],
                    ['id'=>2, 'name'=>'Computers', 'parent_id'=>1],
                    ['id'=>3, 'name'=>'Laptops', 'parent_id'=>2],
                ],
                '<li><a href="http://udemy-phpunit-slim.loc/show-category/1,Electronics">Electronics</a><ul class="submenu menu vertical" data-submenu><li><a href="http://udemy-phpunit-slim.loc/show-category/2,Computers">Computers</a><ul class="submenu menu vertical" data-submenu><li><a href="http://udemy-phpunit-slim.loc/show-category/3,Laptops">Laptops</a></li></ul></li></ul></li>',
                [
                    ['name'=>'Electronics', 'id'=>1],
                    ['name'=>'&nbsp;&nbsp;Computers', 'id'=>2],
                    ['name'=>'&nbsp;&nbsp;&nbsp;&nbsp;Laptops', 'id'=>3],
                ]
            ],
        ];
    }
}