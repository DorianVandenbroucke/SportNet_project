<?php

namespace app\views;

use app\utils\Util;

class DefaultView  extends AbstractView{

    public function __construct($data){
        parent::__construct($data);
    }

    protected function renderHome(){
  		$html =
              "<div class='row presentation'>
                <h1 class='row'>Bienvenue sur SportNet, le rendez-vous des plus grands sportifs</h1>
                <form class='row' action='$this->script_name/event/add/'>
                  <button class='blue-btn'>Ajouter un événement</a>
                </form>
              </div>";

        foreach ($this->data as $event){
            $dateStart = $event->startDate;
            $dateStart = explode("-", $dateStart);
            $dateStart = $dateStart['2']."/".$dateStart['1']."/".$dateStart['0'];

            $dateEnd = $event->endDate;
            $dateEnd = explode("-", $dateEnd);
            $dateEnd = $dateEnd['2']."/".$dateEnd['1']."/".$dateEnd['0'];
            $html.="<div class='row list'>
                    <div class='ligne row'>
                        <div class='column_4'>
                          <h3>$event->name</h3>
                          <p>Du $dateStart au $dateEnd</p>
                        </div>
                        <div class='column_4 buttons_list'>
                            <a class='lightblue_button' href='$this->script_name/event/?id=$event->id'>Details</a>";
                            if(Util::isEventModifyable($event)) {
                                $html .= "<a href='$this->script_name/event/delete/?id=$event->id' class='lightblue_button'>Supprimer</a>";
                            }

                        $html.="</div>
                    </div>
                    </div>";
        }
  		return $html;
    }

    protected function renderSigninForm(){
      $html =
              "<div class='page_header row'>
                <h1>Se connecter</h1>
              </div>
              <form class='row' method='POST' action='$this->script_name/signinVerification/'>
                <div class='column_4'>
                  <label for='login' class='row'>Login</label>
                  <input id='login' class='row' type='text' name='login' placeholder='Login' />
                </div>
                <div class='column_4'>
                  <label for='mdp' class='row'>Mot de passe</label>
                  <input id='mdp' class='row' type='password' name='password' placeholder='Mot de passe' />
                </div>
                <div class='row button'>
                  <button class='blue-btn' name='send'>Connexion</button>
                </div>
                <p class='message_droite row'>Vous n'avez pas encore de compte? <a href='$this->script_name/signup/'>inscrivez-vous</a></p>
              </form>";
              if(isset($_SESSION['message_form'])){
                $html .=
                          "<div class='danger-alert row'>
                            <span>".$_SESSION['message_form']."</span>
                          </div>";
                unset($_SESSION['message_form']);
              }
      return $html;
    }

    protected function renderSignupForm(){
      $html =
              "<h1>S'inscrire</h1>
              <form method='POST' action='$this->script_name/signupVerification/'>
                <div class='column_4'>
                  <label for='login' class='row'>Login</label>
                  <input id='login' class='row' type='text' name='login' placeholder='Login' />
                </div>
                <div class='column_4'>
                  <label for='email' class='row'>E-mail</label>
                  <input id='email' class='row' type='email' name='mail' placeholder='E-mail' />
                </div>
                <div class='column_4'>
                  <label for='password' class='row'>Mot de passe</label>
                  <input id='password' class='row' type='password' name='password' placeholder='Mot de passe' />
                </div>
                <div class='column_4'>
                  <label for='password2' class='row'>Confirmer votre mot de passe</label>
                  <input id='password2' class='row' type='password' name='password_confirm' placeholder='Mot de passe' />
                </div>
                <div class='column_4'>
                  <label for='nom' class='row'>Nom</label>
                  <input id='nom' class='row' type='text' name='name' placeholder='Nom' />
                </div>
                <div class='row button'>
                <button class='blue-btn' name='send'>Inscription</button>
              </div>
              <p class='message_droite row'>Vous avez déjà un compte? <a href='$this->script_name/signin/'>connectez-vous</a></p>
              </form>";
              if(isset($_SESSION['message_form'])){
                $html .=
                          "<div class='danger-alert row'>
                            <span>".$_SESSION['message_form']."</span>
                          </div>";
                unset($_SESSION['message_form']);
              }
      return $html;
    }

    public function render($selector){


        switch($selector){
            case 'signinForm':
                $main = $this->renderSigninForm();
                break;
            case 'signupForm':
                $main = $this->renderSignupForm();
                break;
    		default:
    			$main = $this->renderHome();
    			break;
        }

        $framework = $this->app_root.'/css/vandenbr3u_library/css/theme.css';
        $style_file = $this->app_root.'/css/css/style.css';
        $header = $this->renderHeader();
        $menu   = $this->renderMenu();
        $footer = $this->renderFooter();


        $html = <<<EOT
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>SportNet</title>
        <link rel="stylesheet" href="${framework}">
        <link rel="stylesheet" href="${style_file}">
    </head>

    <body class="grid_float">

        <header class="row">${header}</header>

        <div class="row menu">
            ${menu}
    	</div>
        <section class="row content offset_1 column_6">
            ${main}
        </section>

        <footer> ${footer} </footer>

    </body>
</html>
EOT;

    echo $html;

    }


}
