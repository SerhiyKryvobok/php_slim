<?php

use Slim\Container;
use App\Controllers\CategoryController;

class CategoryControllerTest extends \PHPUnit\Framework\TestCase {

    public static $controller;

    public static function setUpBeforeClass(): void
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

        $container = new Container;

        $container['view'] = new \Slim\Views\PhpRenderer('./app/Views/', [
            'baseUrl' => 'http://udemy-phpunit-slim.loc/'
        ]);

        self::$controller = new CategoryController($container);
    }

    public function testCanSeeEditedVideosCategory()
    {
        $environment = \Slim\Http\Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/show-category/13,Videos',
            'QUERY_STRING' => ''
        ]);
        $request = \Slim\Http\Request::createFromEnvironment($environment);

        $response = new \Slim\Http\Response();
        $response = self::$controller->showCategory($request, $response, ['id'=>'13,Videos']);

        $this->assertStringContainsString('Description of Videos', (string)$response->getBody());
    }
}