<?php

session_start();

require_once("vendor/autoload.php");

app\utils\AppInit::bootEloquent('/../conf/conf.ini');

use app\utils\HttpRequest as HttpRequest;
use app\utils\Router as Router;

$router = new Router();

$router->addRoute('default', '\app\controllers\DefaultController', 'home');

$http_req = new HttpRequest();
$router->dispatch($http_req);

// var_dump(Router::$routes);
