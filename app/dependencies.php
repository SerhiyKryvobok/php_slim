<?php
$container = $app->getContainer();

$container['my_service'] = function($c) {
    return 'My service in action. ';
};

$container['view'] = new \Slim\Views\PhpRenderer('../app/Views/');
