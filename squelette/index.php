<?php

session_start();
define("EVENT_STATUS_CLOSED", 0);
define("EVENT_STATUS_OPEN", 1);
require_once("vendor/autoload.php");

app\utils\AppInit::bootEloquent('conf/conf.ini');

use app\utils\HttpRequest as HttpRequest;
use app\utils\Router as Router;

$router = new Router();

$router->addRoute('default', '\app\controllers\DefaultController', 'home');
$router->addRoute('/signin/', '\app\controllers\DefaultController', 'signinForm');
$router->addRoute('/signinVerification/', '\app\controllers\DefaultController', 'signinVerification');
$router->addRoute('/signup/', '\app\controllers\DefaultController', 'signupForm');
$router->addRoute('/signupVerification/', '\app\controllers\DefaultController', 'signupVerification');
$router->addRoute('/event/add/', '\app\controllers\EventController', 'addEvent');
$router->addRoute('/event/save/', '\app\controllers\EventController', 'saveEvent');
$router->addRoute('/event/', '\app\controllers\EventController', 'detailEvent');

$http_req = new HttpRequest();
$router->dispatch($http_req);

// var_dump(Router::$routes);
