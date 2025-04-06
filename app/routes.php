<?php

use App\Controllers\HomeController;
use App\Controllers\LearnController;


$app->get('/', HomeController::class . ':home');

// Learn tasks route
$app->get('/task/{task}', LearnController::class . ':task');