<?php

use App\Controllers\HomeController;
use App\Controllers\LearnController;


$app->get('/hello/{name}', HomeController::class . ':home');

$app->get('/task/{task}', LearnController::class . ':task');