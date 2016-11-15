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
		$events = Event::select('id', 'name', 'description')->skip(10);
		$defaultView = new DefaultView($events);
		$defaultView->render('home');
	}
	
	public function signinForm(){
		$defaultView = new DefaultView(NULL);
		$defaultView->render('signinForm');
	}
	
	public function signinVerification(){
		$login = $_POST['login'];
	}
	
}