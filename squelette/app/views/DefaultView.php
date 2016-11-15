<?php

namespace app\views;

class DefaultView  extends AbstractView{

    public function __construct($data){
        parent::__construct($data);
    }

    protected function home(){
        $html = "";
        foreach ($this->data as $value){
            $html.="<li><a href='$this->script_name/wiki/view/?title=$value->title'>$value->title</a></li>";
        }
        return "<ul id='menu2'>$html</ul>";

    }

    public function render($selector){


        switch($selector){
			default:
				$main = $this->home();
				break;
        }

        $header = $this->renderHeader();
        $menu   = $this->renderMenu();
        $footer = $this->renderFooter();

        $html = <<<EOT
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>MiniWiki</title>
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

