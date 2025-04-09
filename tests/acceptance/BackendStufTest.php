<?php

use App\Models\Category;
use PHPUnit\Extensions\Selenium2TestCase;

class BackendStufTest extends Selenium2TestCase {

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

        $capsule::schema()->dropIfExists('categories');

        $capsule::schema()->create('categories', function(Illuminate\Database\Schema\Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable(false);
            $table->bigInteger('parent_id')->unsigned()->nullable();
        });

        // $capsule::table('categories')->insert(
        //     ['name' => 'Electronics']
        // );

        Category::create([
            'name' => 'Electronics'
        ]);
    }

    public function setUp(): void
    {
        $this->setHost(PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_HOST);
        $this->setPort((int)PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_PORT);
        $this->setBrowser(PHPUNIT_TESTSUITE_EXTENSION_SELENIUM2_BROWSER);
        if (!defined('PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_TESTS_URL')) {
            $this->markTestSkipped("You must serve the selenium-1-tests folder from an HTTP server and configure the PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_TESTS_URL constant accordingly.");
        }
        $this->setBrowserUrl(PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_TESTS_URL);
    }

    public function testCanSeeAddedCategories()
    {
        $this->url('');
        $element = $this->byXPath('//ul[@class="dropdown menu"]/li[2]/a');
        $href = $element->attribute('href');
        $this->assertEquals('Electronics', $element->text());
        $this->assertMatchesRegularExpression('@^http://udemy-phpunit-slim.loc/show-category/[0-9]+,Electronics$@', $href);

        $this->url('show-category/1');
        $element = $this->byXPath('//ul[@class="dropdown menu"]/li[2]/a');
        $href = $element->attribute('href');
        $this->assertEquals('Electronics', $element->text());
        $this->assertMatchesRegularExpression('@^http://udemy-phpunit-slim.loc/show-category/[0-9]+,Electronics$@', $href);
    }


}