<?php
namespace app\utils;
use app\models\Promoter;

/**
 * Created by PhpStorm.
 * User: marco
 * Date: 5/10/16
 * Time: 10:33
 */
class Authentification extends AbstractAuthentification
{

    public function __construct(){
         if(isset($_SESSION['promoter'])){
            $this->promoter = $_SESSION['promoter'];
            $this->logged_in = true;
        }else{
            $this->promoter = null;
            $this->logged_in = false;
        }
    }


    public function login($login, $pass)
    {
        $promoter= Promoter::findByName($login);
        if(!is_null($promoter) && password_verify($pass, $promoter->password)){
           $this->promoter = $promoter->id;
            $_SESSION['promoter'] = $this->promoter;
            $this->logged_in = true;
        }else{
            $this->logged_in = false;
        }
        return $this->logged_in;
    }

    public function logout()
    {
        unset($_SESSION['promoter']);
        $this->logged_in = false;
        $this->promoter = null;
    }

    public function createUser($name, $mail, $login, $password){

      $promoter = new Promoter();
      $promoter->name = $name;
      $promoter->mail = $mail;
      $promoter->login = $login;
      $promoter->password = password_hash($password, PASSWORD_DEFAULT);
      $promoter->save();

		  return $promoter->id;
    }

}
