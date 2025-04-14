<?php

use App\Models\Category;
use App\Services\DataBaseConnection;
use PHPUnit\Extensions\Selenium2TestCase;

class BackendStufTest extends Selenium2TestCase {

    public static function setUpBeforeClass(): void
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

        // $dbConn = new DataBaseConnection;
        // $capsule = $dbConn->create();
        $capsule = DataBaseConnection::create();

        $capsule::schema()->dropIfExists('categories');

        $capsule::schema()->create('categories', function(Illuminate\Database\Schema\Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable(false);
            $table->text('description')->nullable(false);
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });

        // $capsule::table('categories')->insert(
        //     ['name' => 'Electronics']
        // );
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
        Category::create([
            'name' => 'Electronics',
            'description' => 'Description of Electronics'
        ]);

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

    /**
     * @depends testCanSeeAddedCategories
     */
    public function testCanAddChildCategory()
    {
        $electronics = Category::where('name', 'Electronics')->first();
        $electronics->children()->saveMany([
            new Category(['name' => 'Monitors','description' => 'Description of Monitors']),
            new Category(['name' => 'Tablets','description' => 'Description of Tablets']),
            new Category(['name' => 'Computers','description' => 'Description of Computers']),
        ]);

        $computers = Category::where('name', 'Computers')->first();
        $computers->children()->saveMany([
            new Category(['name' => 'Desktops','description' => 'Description of Desktops']),
            new Category(['name' => 'Notebook','description' => 'Description of Notebook']),
            new Category(['name' => 'Laptops','description' => 'Description of Laptops']),
        ]);

        $laptops = Category::where('name', 'Laptops')->first();
        $laptops->children()->saveMany([
            new Category(['name' => 'Asus','description' => 'Description of Asus']),
            new Category(['name' => 'Dell','description' => 'Description of Dell']),
            new Category(['name' => 'Acer','description' => 'Description of Acer']),
        ]);

        $acer = Category::where('name', 'Acer')->first();
        $acer->children()->saveMany([
            new Category(['name' => 'FullHD','description' => 'Description of FullHD']),
            new Category(['name' => 'HD+','description' => 'Description of HD+']),
        ]);

        Category::create([
            'name'=>'Videos',
            'description'=>'Description of Videos',
        ]);
        Category::create([
            'name'=>'Software',
            'description'=>'Description of Software',
        ]);

        $software = Category::where('name','Software')->first();
        $software->children()->saveMany([
            new Category(['name'=>'Operating systems','description'=>'Description of Operating systems']),
            new Category(['name'=>'Servers','description'=>'Description of Servers'])
        ]);

        $operating_systems = Category::where('name','Operating systems')->first();
        $operating_systems->children()->saveMany([
            new Category(['name'=>'Linux','description'=>'Description of Linux'])
        ]);

        $this->url('');
        $element = $this->byXPath('//ul[@class="dropdown menu"]/li[2]/ul[1]/li[1]/a');
        $href = $element->attribute('href');
        // $this->assertEquals('Monitors', $element->text());
        $this->assertMatchesRegularExpression('@^http://udemy-phpunit-slim.loc/show-category/[0-9]+,Monitors$@', $href);
    }

    /**
     * @depends testCanAddChildCategory
     */
    public function testCanSeePopulatedFormDataWhenCategoryIsEdited()
    {
        $this->url('edit-category/17');
        sleep(1);
        $category_name = $this->byName('category-name');
        $name = $category_name->value();
        $this->assertSame('Linux', $name);

        $category_desc = $this->byName('category-description');
        $desc = $category_desc->value();
        $this->assertSame('Description of Linux', $desc);
    }

    /**
     * @depends testCanSeePopulatedFormDataWhenCategoryIsEdited
     */
    public function testCanSeeCorrectParentCategoryWhenEditedChildCategory()
    {
        $this->url('edit-category/17');
        sleep(1);
        $select = $this->select($this->byId('select_category_list'))->selectedValue();
        $this->assertSame('15', $select);
    }

    /**
     * @depends testCanSeeCorrectParentCategoryWhenEditedChildCategory
     */
    public function testCanSeeCategoryIdToBeEdited()
    {
        $this->url('edit-category/17');
        $this->assertStringContainsString('input type="hidden" name="category_id"', $this->source());

        $this->url('show-category/17,Linux');
        sleep(1);
        $this->assertStringNotContainsString('input type="hidden" name="category_id"', $this->source());
    }

    /**
     * @depends testCanSeeCategoryIdToBeEdited
     */
    public function testCanEditCategory()
    {
        $this->url('edit-category/17');
        $categoryName = $this->byName('category-name');
        $categoryName->clear();
        $categoryName->value('Windows');

        $categoryDescription = $this->byName('category-description');
        $categoryDescription->clear();
        $categoryDescription->value('Description of Windows');

        $this->select($this->byId('select_category_list'))->selectOptionByValue('16');

        $button = $this->byCssSelector('input[type="submit"]');
        $button->submit();
        $this->url('');
        sleep(1);
        $this->assertStringNotContainsString('Linux', $this->source());

        $this->url('edit-category/17');
        sleep(1);
        $categoryName = $this->byName('category-name');
        $categoryName->clear();
        $categoryName->value('Linux');
        $categoryDescription = $this->byName('category-description');
        $categoryDescription->clear();
        $categoryDescription->value('Description of Linux');
        $this->select($this->byId('select_category_list'))->selectOptionByValue('15');
        $button = $this->byCssSelector('input[type="submit"]');
        $button->submit();
    }

    /**
     * @depends testCanEditCategory
     */
    public function testCanAddCategory()
    {
        $this->url('');
        sleep(1);
        $categoryName = $this->byName('category-name');
        $categoryName->value('Windows');
        $categoryDescription = $this->byName('category-description');
        $categoryDescription->value('Description of Windows');
        $this->select($this->byId('select_category_list'))->selectOptionByValue('15');
        $button = $this->byCssSelector('input[type="submit"]');
        $button->submit();
        sleep(1);
        $this->url('show-category/18,Windows');
        sleep(1);
        $this->assertStringContainsString('Description of Windows', $this->source());
    }
 
}