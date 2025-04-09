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
                '<ul><li>Electronics</li><li>Videos</li><li>Software</li></ul>',
                [
                    ['name'=>'Electronics'],
                    ['name'=>'Videos'],
                    ['name'=>'Software'],
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
                '<ul><li>Electronics<ul><li>Computers</li></ul></li></ul>',
                [
                    ['name'=>'Electronics'],
                    ['name'=>'&nbsp;&nbsp;Computers'],
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
                '<ul><li>Electronics<ul><li>Computers<ul><li>Laptops</li></ul></li></ul></li></ul>',
                [
                    ['name'=>'Electronics'],
                    ['name'=>'&nbsp;&nbsp;Computers'],
                    ['name'=>'&nbsp;&nbsp;&nbsp;&nbsp;Laptops'],
                ]
            ],
        ];
    }
}