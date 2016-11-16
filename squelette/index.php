<?php

session_start();

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
$router->addRoute('/logout/', '\app\controllers\DefaultController', 'logout');
$router->addRoute('/activity/add', '\app\controllers\ActivityController', 'add');
$router->addRoute('/activity/edit', '\app\controllers\ActivityController', 'update');
$router->addRoute('/activity/delete', '\app\controllers\ActivityController', 'delete');
$router->addRoute('/activity/detail/', '\app\controllers\ActivityController', 'detail');
$router->addRoute('/activity/register', '\app\controllers\ActivityController', 'register');
$router->addRoute('/event/add/', '\app\controllers\EventController', 'addEvent');


$http_req = new HttpRequest();
$router->dispatch($http_req);

 //var_dump(Router::$routes);
