<?php

namespace app\views;


class ActivityView extends AbstractView
{

    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function render($selector)
    {
        switch ($selector) {
            case 'detail':
                $main = $this->detail();
                break;
            case 'add':
                $main = $this->add();
                break;     
            case 'edit':
                $main = $this->edit();
                break;                                       
            case 'register':
                $main = $this->register();
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

    public function detail(){
        return '<h1>'.$this->data->name.'</h1>
        <section class="row">
                <section class="column_5">
                <p>'.$this->data->description.'</p><br>
                </section>
                <aside class="column_3">
                <form action="'.$this->script_name.'/" methode="post"><input type="submit" name="publishResults" value="Publier les résultats"/></form>
                <form action="'.$this->script_name.'/" methode="post"><input type="submit" name="editActivity" value="Modifier l\'épreuve"/></form>
                <form action="'.$this->script_name.'/" methode="post"><input type="submit" name="deleteActivity" value="Supprimer l\'épreuve"/></form>
                <h3>Date de l\'épreuve :'.$this->data->date.'</h3>
                </aside>
           </section>
           <section class="row">
                <div class="column_3"><form action="#" methode="post"><input type="submit" name="inscriptionEpreuve" value="S\'inscrire à l\'épreuve"/></form></div>
                <div class="column_3"><form action="#" methode="post"><input type="submit" name="resultats" value="Voir les résultats"/></form></div>
           </section>';
    }

    public function add(){
        return '<h1>Ajouter une epreuve</h1><hr>
                <form action="#" method="POST"/>
                <label>Titre de l\'epreuve</label><input type="text" name="name" required/><br>
                <label>Description</label><textarea name="description"></textarea><br>
                <label>Date de l\'epreuve</label><input type="text" name="date" required/><br>
                <label>Heure de l\'epreuve</label><input type="text" name="date" required/><br>
                <label>Tarif de l\'epreuve</label<select name="tarif"><option value="euro">€</option><option value="dollar" selected>$</option></select><br>
                <input type="submit" name="valider"/>
                </form>';         
    }

    public function edit(){
        return '<h1>Modifier une epreuve</h1><hr>
                <form action="#" method="POST"/>
                <label>Titre de l\'epreuve</label><input type="text" name="name" value="'.$this->data->name.'" required/><br>
                <label>Description</label><textarea name="description">'.$this->data->description.'</textarea><br>
                <label>Date de l\'epreuve</label><input type="text" name="date" value="'.$this->data->date.'" required/><br>
                <label>Heure de l\'epreuve</label><input type="text" name="date" required/><br>
                <label>Tarif de l\'epreuve</label<select name="tarif"><option value="euro">€</option><option value="dollar" selected>$</option></select><br>
                <input type="submit" name="valider"/>
                </form>';         
    }

    public function register(){
        return '<h1>Inscription à une épreuve</h1>
                <form action="#" method="POST"/>
                <label>Prénom :/label><input type="text" name="firstName"  required/><br>
                <label>Nom :</label><input type="text" name="lastName" required/><br>
                <label>Mail :</label><input type="text" name="mail" required/><br>
                <label>Date de naissance :</label><input type="text" name="birthDate" required/><br>
                <input type="submit" name="register" value="S\'inscrire"/>
                <button>Clear</button>
                </form>';
    }

    public function result(){
        return '<section class="row">
                <h1>Résultat généraux de l\'épreuve</h1>
                <h2>Marathon Kids</h2>
                <form action="#" method="POST"/><input type="text" name="searchQuery"/><input type="submit" name="search" value="Recherche"/></form>
                <table>
                <tr><th>Ranking</th><th>Score</th><th>N°PArticipant</th><th>Nom</th></tr>
                <tr>'.foreach ($this->data->getParticipants as $participant) {
                    .'<td>'.$participant->pivot->score.'</td><td>'.$participant->firstName.'</td><td>'.$participant->firstName.'</td><td>'.$participant->birthDay.'</td>'.
                }.'</tr><tr><td>Ranking</td><td>Score</td><td>N°PArticipant</td><td>Nom</td></tr>
                
                </table>
                </section>';
    }
}    

 