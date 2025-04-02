<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;

class BaseController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    function console_log($msg)
    {
        $message = json_encode($msg);
        echo "<script>console.log({$message})</script>";
    }
}