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
$router->addRoute('/activity/all/', '\app\controllers\ActivityController', 'all');
$router->addRoute('/activity/add/', '\app\controllers\ActivityController', 'add');
$router->addRoute('/activity/add', '\app\controllers\ActivityController', 'add');
$router->addRoute('/activity/edit/', '\app\controllers\ActivityController', 'update');
$router->addRoute('/activity/delete/', '\app\controllers\ActivityController', 'delete');
$router->addRoute('/activity/detail/', '\app\controllers\ActivityController', 'detail');
$router->addRoute('/activity/register/', '\app\controllers\ActivityController', 'register');
$router->addRoute('/activity/result/', '\app\controllers\ActivityController', 'result');
$router->addRoute('/event/add/', '\app\controllers\EventController', 'saveEventForm');
$router->addRoute('/event/edit/', '\app\controllers\EventController', 'saveEventForm');
$router->addRoute('/event/save/', '\app\controllers\EventController', 'saveEvent');
$router->addRoute('/event/delete/', '\app\controllers\EventController', 'deleteEvent');
$router->addRoute('/event/', '\app\controllers\EventController', 'detailEvent');
$router->addRoute('/event/all/', '\app\controllers\EventController', 'findAll');
$router->addRoute('/event/search/', '\app\controllers\EventController', 'search');
$router->addRoute('/event/close/', '\app\controllers\EventController', 'close');
$router->addRoute('/myEvents/', '\app\controllers\EventController', 'myEvents');
$router->addRoute('/logout/', '\app\controllers\DefaultController', 'logout');

// On redirige automatiquement un organisateur à sa connexion vers la page précédent son authentification;
if(!isset($_SESSION['promoter'])){
    if(
      isset($_SERVER["PATH_INFO"]) &&
      $_SERVER['PATH_INFO'] != "/signin/" &&
      $_SERVER['PATH_INFO'] != "/signup/" &&
      $_SERVER['PATH_INFO'] != "/signupVerification/" &&
      $_SERVER['PATH_INFO'] != "/signinVerification/" &&
      $_SERVER['PATH_INFO'] != "/logout/"
    ){
      $_SESSION['url_redirection'] = $_SERVER['PATH_INFO'];
      if($_SERVER['QUERY_STRING']){
        $_SESSION['url_redirection'] = $_SESSION['url_redirection']."?".$_SERVER['QUERY_STRING'];
      }
    }else{
      $_SESSION['url_redirection'] = "";
    }
}

// On crée une variable de session dans le cas où l'utilisateur souhaite retourner sur une page précéDefaultController
if(
  isset($_SERVER["PATH_INFO"]) &&
  $_SERVER['PATH_INFO'] != "/event/"
){
  $_SESSION['return_button'] = $_SERVER['PATH_INFO'];
  if($_SERVER['QUERY_STRING']){
    $_SESSION['return_button'] = $_SESSION['return_button']."?".$_SERVER['QUERY_STRING'];
  }
}

$http_req = new HttpRequest();
$router->dispatch($http_req);

 //var_dump(Router::$routes);
