<?php

use App\Controllers\FirstController;


$app->get('/hello/{name}', FirstController::class . ':home');