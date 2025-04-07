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

    public function testCanSeConfirmDialogBoxWhenTryingToDeleteCategory()
    {
        $this->url('');
        $this->clickOnElement('deletecategoryconfirmation');
        $this->waitUntil(function () {
            if ($this->alertIsPresent()) return true;
            return null;
        }, 4000);
        $this->dismissAlert();
        $this->assertTrue(true);
    }

    public function testCanSeeCorrectMessageAfterDeletingCategory()
    {
        $this->url('');
        $this->clickOnElement('deletecategoryconfirmation');
        $this->waitUntil(function () {
            if ($this->alertIsPresent()) return true;
            return null;
        }, 4000);
        $this->acceptAlert();
        $this->assertStringContainsString('Category was deleted', $this->source());
        $this->markTestIncomplete('Message about deleted category should appear after redirection');
    }
}