<?php

use App\Services\CategoryTree;

class CategoryTreeTest extends PHPUnit\Framework\TestCase {

    public function testCanConvertDatabaseResultToCategoryArray()
    {
        $db_result = [
            ['id'=>1, 'name'=>'Electronics', 'parent_id'=>null],
            ['id'=>2, 'name'=>'Videos', 'parent_id'=>null],
            ['id'=>3, 'name'=>'Software', 'parent_id'=>null],
        ];

        $after_conversion = [
            ['id'=>1, 'name'=>'Electronics', 'parent_id'=>null, 'children'=>[]],
            ['id'=>2, 'name'=>'Videos', 'parent_id'=>null, 'children'=>[]],
            ['id'=>3, 'name'=>'Software', 'parent_id'=>null, 'children'=>[]],
        ];

        $tree = new CategoryTree();
        $this->assertEquals($after_conversion, $tree->convert($db_result));
    }

    public function testCanConvertDatabaseResultToOneLevelNestedArray()
    {
        $tree = new CategoryTree();

        $db_result = [
            ['id'=>1, 'name'=>'Electronics', 'parent_id'=>null],
            ['id'=>2, 'name'=>'Computers', 'parent_id'=>1],
        ];

        $after_conversion = [
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
        ];

        $this->assertEquals($after_conversion, $tree->convert($db_result));
    }

    public function testCanConvertDatabaseResultToTwoLevelNestedArray()
    {
        $tree = new CategoryTree();

        $db_result = [
            ['id'=>1, 'name'=>'Electronics', 'parent_id'=>null],
            ['id'=>2, 'name'=>'Computers', 'parent_id'=>1],
            ['id'=>3, 'name'=>'Laptops', 'parent_id'=>2],
        ];

        $after_conversion = [
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
            ],
        ];

        $this->assertEquals($after_conversion, $tree->convert($db_result));
    }
}