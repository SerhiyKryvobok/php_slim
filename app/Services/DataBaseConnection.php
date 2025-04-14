<?php

namespace App\Services;

class DataBaseConnection {
    public static function create()
    {
        $connection = (isset($container['settings']['db'])) ? $container['settings']['db'] : [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'database' => 'php-slim',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ];
        
        $capsule = new \Illuminate\Database\Capsule\Manager;
        $capsule->addConnection($connection);
        $capsule->setAsGlobal(); // allow static methods
        $capsule->bootEloquent(); // setup the Eloquent ORM

        return $capsule;
    }
}