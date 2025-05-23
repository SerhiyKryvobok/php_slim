<?php

use App\Services\CategoriesFactory;
use App\Services\DataBaseConnection;

class CategoriesFactoryTest extends PHPUnit\Framework\TestCase {

    public function testCanProduceStringBasedOnArray()
    {
        // $capsule = new \Illuminate\Database\Capsule\Manager;

        // $capsule->addConnection([
        //     'driver' => 'mysql',
        //     'host' => '127.0.0.1',
        //     'database' => 'php-slim',
        //     'username' => 'root',
        //     'password' => '',
        //     'charset' => 'utf8mb4',
        //     'collation' => 'utf8mb4_unicode_ci',
        //     'prefix' => '',
        // ]);
        // $capsule->setAsGlobal(); // allow static methods
        // $capsule->bootEloquent(); // setup the Eloquent ORM

        $capsule = DataBaseConnection::create();

        $this->assertTrue(is_string(CategoriesFactory::create()['menu_categories']));
        $this->assertTrue(is_array(CategoriesFactory::create()['select_list_categories']));
    }
}