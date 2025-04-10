<?php

use App\Services\CategoriesFactory;

class CategoriesFactoryTest extends PHPUnit\Framework\TestCase {

    public function testCanProduceStringBasedOnArray()
    {
        $capsule = new \Illuminate\Database\Capsule\Manager;

        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'database' => 'php-slim',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ]);
        $capsule->setAsGlobal(); // allow static methods
        $capsule->bootEloquent(); // setup the Eloquent ORM

        $this->assertTrue(is_string(CategoriesFactory::create()));
    }
}