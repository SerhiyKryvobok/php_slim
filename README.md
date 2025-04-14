## 🖖 Hello!
This is a learning suite based on PHP Slim micro framework. Created in order to setup unit testing && TDD approach learning environment.

> [!TIP]
> Additional development vector opened. PHP learning suite under Slim arch.

## First iteration task list:
- [x] Intoduction :tada:
- [x] Basic php slim framework setup
- [x] Added some PHP learning suite tasks, as separate part of a project but under same arch.
- [x] Added additional task to PHP learning suite.
- [x] Setup and adjusting compatibilities and dependencies to get up PHPUnit & Selenium testing environment. Due to misleading in elements versions, methods, webdriver deps and so on.

> [!IMPORTANT]
> For this env use next line (& files) to start selenium server: java "-Dwebdriver.gecko.driver=geckodriver.exe" -jar selenium-server-3.5.0.jar

> [!CAUTION]
> Due to misleading in versions or outdating in between phpunit-selenium and webdriver or etc, there are necesity in correction of local core vendor functionality.

<!-- 
This necessary corr in SeleniumTestSuite.php on line 159 in loop to avoid Selenium from running all class methods, and provoke looong loop.
if (!TestUtil::isTestMethod($method)) {
    continue;
}
if (!$method->isPublic()) {
    continue;
}
-->

## Second iteration task list:
- [x] TDD continues
- [x] Added necessary routes, controller methods, view improvements and tests using Selenium Web Driver to perform proper fontend TDD flow
- [x] Classes & tests refactoring. Using of @dataProvide annotation & recursive method.

> [!CAUTION]
> Strongly recommended to downgrade PHP version to 7.4 in order to avoid uncompatibility errors

> [!NOTE]
> There are a lot of sleep() functions in tests, it placed due to local server behaviour and propably shouldn't be necessary in other environments.

## Third iteration task list:
- [x] Uncompatibility issues due to PHP version solved.
- [x] Appeared new issue with Category model fetching in BackendStufTest methods besides first one. Unsolved🤔.
- [x] Another integration test.
- [x] Core testing learning suite app finished. But everytime there are a place for refactoring.
- [x] App ready. But still doesnt resolved issue with post request and session vars. When unset method has strange behaviour and break logic.

<!-- ## Tech stack
| th1 | th2  | th3 | th4 |
|--------------------------|--------------------------------|----------------------------|--------------------|
| td1 | td2 | td3 | td4 |

> [!WARNING]
> Urgent info that needs immediate user attention to avoid problems.
-->

### 🤝 Interested in colaboration ? Feel free to join! 😎