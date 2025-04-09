<?php
$container = $app->getContainer();

$container['my_service'] = function($c) {
    return 'My service in action. ';
};

$container['view'] = new \Slim\Views\PhpRenderer('../app/Views/', [
    'baseUrl' => 'http://udemy-phpunit-slim.loc/'
]);

// $container['db'] = function ($container) {
    $capsule = new \Illuminate\Database\Capsule\Manager;

    $capsule->addConnection($container['settings']['db']);
    $capsule->setAsGlobal(); // allow static methods
    $capsule->bootEloquent(); // setup the Eloquent ORM

//     return $capsule;
// };
