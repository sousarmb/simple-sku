<?php

require_once '..' . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'boot.php';

$router = new \framework\Router($routes);
$kernel = new \framework\Kernel();

$kernel->go($router->routeTo());
