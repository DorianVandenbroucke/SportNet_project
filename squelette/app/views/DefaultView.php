<?php

namespace app\views;

class DefaultView  extends AbstractView{

    public function __construct($data){
        parent::__construct($data);
    }

    protected function renderHome(){
  		$html =
              "<div class='row presentation'>
                <h1 class='row'>Bienvenue sur SportNet, le rendez-vous des plus grands sportifs</h1>
                <div class='row'>
                  <a href='$this->script_name/event/add/'><button>Ajouter un événement</button></a>
                </div>
              </div>";

  		foreach($this->data as $value){
  			$html .=
  					"<div class='row'>
  						<h2>".$value->name ."</h2>
  						<div>Du ".$value->startDate ." au ".$value->endDate ."</div>
  						<a href='$this->script_name/event/?id=".$value->id ."'>Voir plus</a>"
  					."</div>";
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
                  <label class='row'>Login:</label>
                  <input class='row' type='text' name='login' placeholder='Login' />
                </div>
                <div class='column_4'>
                  <label class='row'>Mot de passe:</label>
                  <input class='row' type='password' name='password' placeholder='Mot de passe' />
                </div>
                <div class='row button'>
                  <button name='send'>Connexion</button>
                </div>
                <p class='message_droite row'>Vous n'avez pas encore de compte? <a href='$this->script_name/signup/'>inscrivez-vous</a></p>.
              </form>";
      return $html;
    }

    protected function renderSignupForm(){
      $html =
              "<h1>S'inscrire</h1>
              <form method='POST' action='$this->script_name/signupVerification/'>
                <input type='text' name='name' placeholder='Nom' />
                <input type='text' name='mail' placeholder='E-mail' />
                <input type='text' name='login' placeholder='Login' />
                <input type='password' name='password' placeholder='Mot de passe' />
                <input type='password' name='password_confirm' placeholder='Confirmez votre mot de passe' />
                <button name='send'>Inscription</button>
              </form>
              Vous avez déjà un compte? <a href='$this->script_name/signin/'>connectez-vous</a>.";
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
