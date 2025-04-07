<?php

use App\Controllers\HomeController;
use App\Controllers\LearnController;
use App\Controllers\CategoryController;


$app->get('/', HomeController::class . ':home');
$app->get('/delete-category', CategoryController::class . ':deleteCategory');

// Learn tasks route
$app->get('/task/{task}', LearnController::class . ':task');