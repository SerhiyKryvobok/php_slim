<?php

use PHPUnit\Extensions\Selenium2TestCase;

class FrontendStufTest extends Selenium2TestCase {

    public function setUp(): void
    {
        // $this->setBrowserUrl('http://udemy-phpunit-slim.loc');
        // $this->setBrowser('chrome');
        // $this->setDesiredCapabilities(['chromeOptions' => ['w3c' => false]]);

        $this->setHost(PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_HOST);
        $this->setPort((int)PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_PORT);
        $this->setBrowser(PHPUNIT_TESTSUITE_EXTENSION_SELENIUM2_BROWSER);
        if (!defined('PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_TESTS_URL')) {
            $this->markTestSkipped("You must serve the selenium-1-tests folder from an HTTP server and configure the PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_TESTS_URL constant accordingly.");
        }
        $this->setBrowserUrl(PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_TESTS_URL);
    }

    /**
     * @covers PHPUnit\Extensions\Selenium2TestCase
     */
    public function testCanSeeCorrectStringsOnMainPage(): void
    {
        $this->url('');
        // $this->assertContains('Add a new category', $this->source());
        $this->assertStringContainsString('Add a new category', $this->source());
    }

    public function testCanSeeConfirmDialogBoxWhenTryingToDeleteCategory()
    {
        $this->url('show-category/1');
        $this->clickOnElement('delete-category-confirmation');
        $this->waitUntil(function () {
            if ($this->alertIsPresent()) return true;
            return null;
        }, 4000);
        $this->dismissAlert();
        $this->assertTrue(true);
    }

    public function testCanSeeCorrectMessageAfterDeletingCategory()
    {
        $this->url('show-category/1');
        $this->clickOnElement('delete-category-confirmation');
        $this->waitUntil(function () {
            if ($this->alertIsPresent()) return true;
            return null;
        }, 4000);
        $this->acceptAlert();
        sleep(1);
        $this->assertStringContainsString('Category was deleted', $this->source());
        $this->markTestIncomplete('Message about deleted category should appear after redirection');
    }

    public function testCanSeeEditAndDeleteLinksAndCategoryName()
    {
        $this->url('');
        $electronics = $this->byLinkText('Electronics');
        $electronics->click();
        $h5 = $this->byCssSelector('div.basic-card-content h5');
        $this->assertStringContainsString('Electronics', $h5->text());

        $editLink = $this->byLinkText('Edit');
        $href = $editLink->attribute('href');
        $this->assertStringContainsString('edit-category/1', $href);

        $this->markTestIncomplete('Category name, description, edit,delete links must be dinamic');
    }

    public function testCanSeeEditCategoryMessage()
    {
        $this->url('show-category/1');
        $editLink = $this->byLinkText('Edit');
        $editLink->click();
        $this->assertStringContainsString('Edit category', $this->source());

        $this->markTestIncomplete('Make input values dinamic');
    }

    public function testCanSeeFormValidation()
    {
        $this->url('');
        $btn = $this->byCssSelector('input[type="submit"]');
        $btn->submit();
        sleep(1);
        $this->assertStringContainsString('Fill correctly the form', $this->source());

        $this->back();
        sleep(1);
        $categoryName = $this->byName('category-name');
        $categoryName->value('Name');
        $categoryDescription = $this->byName('category-description');
        $categoryDescription->value('Description');
        $btn = $this->byCssSelector('input[type="submit"]');
        $btn->submit();
        sleep(1);
        $this->assertStringContainsString('Category was saved', $this->source());

        $this->markTestIncomplete('More jobs with html form needed');
    }

    public function testCanSeeNestedCategories()
    {
        $this->url('');
        $categories = $this->elements($this->using('css selector')->value('ul.dropdown li'));
        $this->assertEquals(18, count($categories));

        $elem = $this->byCssSelector('ul.dropdown > li:nth-child(2) > a');
        $this->assertEquals('Electronics', $elem->text());

        $elem = $this->byCssSelector('ul.dropdown > li:nth-child(3) > a');
        $this->assertEquals('Videos', $elem->text());

        $elem = $this->byCssSelector('ul.dropdown > li:nth-child(4) > a');
        $this->assertEquals('Software', $elem->text());

        // $elem = $this->byCssSelector('ul.dropdown > :nth-child(2) > :nth-child(2) > :nth-child(1) > a');
        // $this->assertEquals('Software', $elem->text());
        $elem = $this->byXPath('//ul[@class="dropdown menu"]/li[2]/ul[1]/li[1]/a');
        $href = $elem->attribute('href');
        // $this->assertRegExp('@^http://udemy-phpunit-slim.loc/show-category/[0-9]+,Monitors$@', $href); // Deprecated assertion
        $this->assertMatchesRegularExpression('@^http://udemy-phpunit-slim.loc/show-category/[0-9]+,Monitors$@', $href);

        $elem = $this->byXPath('//ul[@class="dropdown menu"]/li[2]//ul[1]//ul[1]//ul[1]//ul[1]/li[1]/a');
        $href = $elem->attribute('href');
        $this->assertMatchesRegularExpression('@^http://udemy-phpunit-slim.loc/show-category/[0-9]+,FullHD$@', $href);
    }
}