<?php

use App\Services\CategoriesFactory;
use App\Services\DataBaseConnection;

// $capsule = new \Illuminate\Database\Capsule\Manager;
// $capsule->addConnection($container['settings']['db']);
// $capsule->setAsGlobal(); // allow static methods
// $capsule->bootEloquent(); // setup the Eloquent ORM

$capsule = DataBaseConnection::create();

$categories = CategoriesFactory::create();
$container->view->addAttribute('categories', $categories['menu_categories']);
$container->view->addAttribute('select_list_categories', $categories['select_list_categories']);