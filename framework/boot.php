<?php

mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_language('uni');
mb_regex_encoding('UTF-8');
ob_start('mb_output_handler');
ob_start();

define('DB_DSN', 'mysql:dbname=products;host=192.168.10.10');
define('DB_USER', 'homestead');
define('DB_PASS', 'secret');

require_once 'Router.php';
require_once 'Kernel.php';
require_once 'Factory.php';
$routes = require_once '..' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'routes.php';

function auto_load($ns_class)
{
    $aux = str_replace('\\', DIRECTORY_SEPARATOR, $ns_class);
    require_once '..' . DIRECTORY_SEPARATOR . "$aux.php";
}

spl_autoload_register('auto_load');