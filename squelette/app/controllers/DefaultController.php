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
		if(isset($_SESSION['promoter'])){
			$this->home();
			return false;
		}
		$defaultView = new DefaultView(NULL);
		$defaultView->render('signinForm');
	}

	public function signinVerification(){

		if(isset($_POST['send'])){

			if(!empty($_POST['login']) && !empty($_POST['password'])){
				$login = $_POST['login'];
				$pass = $_POST['password'];

				if(filter_var($login, FILTER_SANITIZE_STRING) && filter_var($pass, FILTER_SANITIZE_STRING)){
					$authentification = new Authentification();
					$auth = $authentification->login($login, $pass);
					if($auth){
						$id_promoter = $_SESSION['promoter'];

						if(isset($_SESSION['url_redirection'])){
							header("location: ..".$_SESSION['url_redirection']);
						}else{
							header("location: ..");
						}

					}else{
						$_SESSION['message_form'] = "Les données entrées ne correspondent pas.";
						$this->signinForm();
					}
				}
			}else{
				$_SESSION['message_form'] = "Veuillez remplir tous les champs.";
				$this->signinForm();
			}
		}

	}

	public function signupForm(){
		if(isset($_SESSION['promoter'])){
			$this->home();
			return false;
		}
		$defaultView = new DefaultView(NULL);
		$defaultView->render('signupForm');
	}

	public function signupVerification(){

		if(isset($_POST['send'])){

			if(
				!empty($_POST['name']) &&
				!empty($_POST['mail']) &&
				!empty($_POST['login']) &&
				!empty($_POST['password']) &&
				!empty($_POST['password_confirm'])
			){
				$name = $_POST['name'];
				$mail = $_POST['mail'];
				$login = $_POST['login'];
				$password = $_POST['password'];
				$password_confirm = $_POST['password_confirm'];

				if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
					if(
						filter_var($name, FILTER_SANITIZE_STRING) &&
						filter_var($mail, FILTER_SANITIZE_STRING) &&
						filter_var($login, FILTER_SANITIZE_STRING) &&
						filter_var($password, FILTER_SANITIZE_STRING) &&
						filter_var($password_confirm, FILTER_SANITIZE_STRING)
					){
						if($password == $password_confirm){
							$authentification = new Authentification();
							$auth = $authentification->createUser($name, $mail, $login, $password);

							if($auth){
								header("location: ../signin/");
							}else{
								$_SESSION['message_form'] = "Une erreur est survenue.";
								$this->signupForm();
							}

						}else{
							$_SESSION['message_form'] = "Les mots de passes entrés ne correspondent pas.";
							return $this->signupForm();
						}

					}
			}else{
				$_SESSION['message_form'] = "L'adresse mail entré est invalide.";
				return $this->signupForm();
			}
		}else{
			$_SESSION['message_form'] = "Veuillez compléter tous les champs.";
			return $this->signupForm();
		}

		}
	}

	public function logout(){
		$authentification = new Authentification();
		$authentification->logout();
		unset($_SESSION['recap']);
		header("location: ..");
		$this->home();
	}

}
