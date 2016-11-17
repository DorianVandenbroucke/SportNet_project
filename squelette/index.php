<?php

session_start();
define("EVENT_STATUS_CREATED", 0);
define("EVENT_STATUS_OPEN", 1);
define("EVENT_STATUS_CLOSED", 2);
define("EVENT_STATUS_VALIDATED", 3);
define("EVENT_STATUS_PUBLISHED", 4);

require_once("vendor/autoload.php");

app\utils\AppInit::bootEloquent('conf/conf.ini');

use app\utils\HttpRequest as HttpRequest;
use app\utils\Router as Router;

$router = new Router();
if(!isset($_SESSION['recap']))
{$_SESSION['recap']=array();}

$router->addRoute('default', '\app\controllers\DefaultController', 'home');
$router->addRoute('/signin/', '\app\controllers\DefaultController', 'signinForm');
$router->addRoute('/signinVerification/', '\app\controllers\DefaultController', 'signinVerification');
$router->addRoute('/signup/', '\app\controllers\DefaultController', 'signupForm');
$router->addRoute('/signupVerification/', '\app\controllers\DefaultController', 'signupVerification');
$router->addRoute('/activity/all/', '\app\controllers\ActivityController', 'all');
$router->addRoute('/activity/add/', '\app\controllers\ActivityController', 'add');
$router->addRoute('/activity/add', '\app\controllers\ActivityController', 'add');
$router->addRoute('/activity/edit/', '\app\controllers\ActivityController', 'update');
$router->addRoute('/activity/delete/', '\app\controllers\ActivityController', 'delete');
$router->addRoute('/activity/detail/', '\app\controllers\ActivityController', 'detail');
$router->addRoute('/activity/register/', '\app\controllers\ActivityController', 'register');
$router->addRoute('/activity/result/', '\app\controllers\ActivityController', 'result');
$router->addRoute('/activity/export/', '\app\controllers\ActivityController', 'export');
$router->addRoute('/paiement/', '\app\controllers\ActivityController', 'paiement');
$router->addRoute('/validatePaiment/', '\app\controllers\ActivityController', 'validatePaiement');
$router->addRoute('/event/add/', '\app\controllers\EventController', 'saveEventForm');
$router->addRoute('/event/edit/', '\app\controllers\EventController', 'saveEventForm');
$router->addRoute('/event/save/', '\app\controllers\EventController', 'saveEvent');
$router->addRoute('/event/delete/', '\app\controllers\EventController', 'deleteEvent');
$router->addRoute('/event/', '\app\controllers\EventController', 'detailEvent');
$router->addRoute('/event/all/', '\app\controllers\EventController', 'findAll');
$router->addRoute('/event/search/', '\app\controllers\EventController', 'search');
$router->addRoute('/event/changeStatus/', '\app\controllers\EventController', 'changeStatus');
$router->addRoute('/myEvents/', '\app\controllers\EventController', 'myEvents');
$router->addRoute('/logout/', '\app\controllers\DefaultController', 'logout');

// On crée une variable de session dans le cas où l'utilisateur souhaite retourner sur une page précéDefaultController
if(!isset($_SESSION['return_button']))
  $_SESSION['return_button'] = array();

if(!isset($_SESSION['agrementation_return_button']))
  $_SESSION['return_button'] = 0;

if(isset($_SERVER['PATH_INFO'])){
  $url_to_return = $_SERVER['PATH_INFO'];
  if($_SERVER['QUERY_STRING']){
    $url_to_return .= "?".$_SERVER['QUERY_STRING'];
  }
}else{
  $url_to_return = "/";
}

$_SESSION['agrementation_return_button'] += 1;
array_push($_SESSION['return_button'], $url_to_return);

echo "<pre>";var_dump($_SESSION);echo"</pre>";

$http_req = new HttpRequest();
$router->dispatch($http_req);

 //var_dump(Router::$routes);
