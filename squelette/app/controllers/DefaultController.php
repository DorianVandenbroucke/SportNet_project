<?php

namespace app\controllers;

use app\utils\Authentification as Authentification;
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
				$pass = $_POST['password'];

				if(filter_var($login, FILTER_SANITIZE_STRING) && filter_var($pass, FILTER_SANITIZE_STRING)){
					$authentification = new Authentification();
					$auth = $authentification->login($login, $pass);
					var_dump($auth);
					if($auth){
						$this->home();
					}else{
						$this->signinForm();
						echo "Les données entrées ne correspondent pas.";
					}
				}
			}else{
				$this->signinForm();
				echo "Veuillez remplir tous les champs.";
			}
		}

	}

	public function signupForm(){
		$defaultView = new DefaultView(NULL);
		$defaultView->render(signupForm);
	}

}
