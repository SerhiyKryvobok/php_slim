<?php

use App\Controllers\FirstController;
use App\Controllers\LearnController;


$app->get('/hello/{name}', FirstController::class . ':home');

$app->get('/task/{task}', LearnController::class . ':task');