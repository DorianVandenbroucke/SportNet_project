<?php

namespace app\views;

class DefaultView  extends AbstractView{

    public function __construct($data){
        parent::__construct($data);
    }

    protected function renderHome(){
  		$html =
              "<div>
                <h1>Bienvenue sur SportNet, le rendez-vous des plus grands sportifs</h1>
                <a href='$this->script_name/event/add/'>Ajouter un événement</a>
              </h1>";

  		foreach($this->data as $value){
  			$html .=
  					"<div>
  						<h2>".$value->name ."</h2>
  						<div>Du ".$value->startDate ." au ".$value->endDate ."</div>
  						<a href='$this->script_name/event/".$value->id ."'>Voir plus</a>"
  					."</div>";
  		}
  		return $html;
    }

    protected function renderSigninForm(){
      $html =
              "<h1>Se connecter</h1>
              <form method='POST' action='$this->script_name/signinVerification/'>
                <input type='text' name='login' placeholder='Login' />
                <input type='password' name='password' placeholder='Mot de passe' />
                <button name='send'>Connexion</button>
              </form>
              Vous n'avez pas encore de compte? <a href='$this->script_name/signup/'>inscrivez-vous</a>.";
      return $html;
    }

    protected function renderSignupForm(){
      $html =
              "<h1>S'inscrire</h1>
              <form method='POST' action='$this->script_name/signupVerification/'>
                <input type='text' name='nom' placeholder='Nom' />
                <input type='text' name='mail' placeholder='E-mail' />
                <input type='text' name='login' placeholder='Login' />
                <input type='password' name='password' placeholder='Mot de passe' />
                <input type='password' name='confirm_password' placeholder='Confirmez votre mot de passe' />
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

    <body>

        <header class="theme-backcolor1"> ${header}  </header>

        <section>

            <aside>

                <nav id="menu" class="theme-backcolor1"> ${menu} </nav>

            </aside>

            <article class="theme-backcolor2">  ${main} </article>

        </section>

        <footer class="theme-backcolor1"> ${footer} </footer>

    </body>
</html>
EOT;

    echo $html;

    }


}
