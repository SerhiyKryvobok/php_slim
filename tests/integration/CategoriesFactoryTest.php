<?php

use App\Services\CategoriesFactory;

class CategoriesFactoryTest extends PHPUnit\Framework\TestCase {

    public function testCanProduceStringBasedOnArray()
    {
        $this->assertTrue(is_string(CategoriesFactory::create()));
    }
}