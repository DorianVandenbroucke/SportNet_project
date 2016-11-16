<?php

namespace app\controllers;

use app\models\Event as Event;
use app\utils\HttpRequest as HttpRequest;

use app\views\DefaultView as DefaultView;

class DefaultController{


	private $request = null;

	public function __construct(HttpRequest $http_req){
		$this->request = $http_req;
	}

	public function home(){
		$events = Event::select()->take(10)->get();
		$defaultView = new DefaultView($events);
		$defaultView->render('home');
	}

	public function signinForm(){
		$defaultView = new DefaultView(NULL);
		$defaultView->render('signinForm');
	}

	public function signinVerification(){
		if(isset($_POST['send'])){

			if(!empty($_POST['login']) || !empty($_POST['password'])){

			$login = $_POST['login'];
			$password = $_POST['password'];

			if(filter_var($login, FILTER_SANITIZE_STRING) && filter_var($pass, FILTER_SANITIZE_STRING)){

			}
			}

		}
	}

}
