<?php

namespace app\views;

class DefaultView  extends AbstractView{

    public function __construct($data){
        parent::__construct($data);
    }

    protected function home(){
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

    protected function signinForm(){
      $html =
              "<h1>Se connecter</h1>
              <form method='POST' action='$this->script_name/signinVerification/'>
                <input type='text' name='login' placeholder='Login' />
                <input type='password' name='password' placeholder='Mot de passe' />
                <button name='send'>Connexion</button>
              </form>";
      return $html;
    }

    public function render($selector){


        switch($selector){
          case 'signinForm':
            $main = $this->signinForm();
            break;
    			default:
    				$main = $this->home();
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
