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
            case 'all':
                $main = $this->all();
                break;
            case 'result':
                $main = $this->result();
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
                <a href="#">Publier les résultas</a><br>
                <a href="'.$this->script_name.'/activity/edit/?id='.$this->data->id.'">Modifier</a><br>
                <a href="'.$this->script_name.'/activity/delete/?id='.$this->data->id.'">Supprimer</a><br>
                <h3>Date de l\'épreuve :'.$this->data->date.'</h3>
                </aside>
           </section>
           <section class="row">
                <div class="column_3"><a href="'.$this->script_name.'/activity/register/?id='.$this->data->id.'">S\'inscrire</a> </div>
                <div class="column_3"><a href="'.$this->script_name.'/activity/result/?id='.$this->data->id.'">Résultats</a> </div>
           </section>';
    }

    public function add(){
        return "<div class='page_header row'>
                    <h1>Ajouter une épreuve</h1>
                </div>
                <form action='#' method='POST'/>
                <div class='column_4'>
                    <label for='nom'>Titre de l'épreuve</label>
                    <input type='text' id='nom' placeholder='Nom' name='name' required>
                </div>
                <div class='column_4'>
                    <label for='desc'>Description</label>
                    <textarea id='desc' name='description'></textarea>
                </div>
                <div class='column_4'>
                    <label for='date'>Date de l'épreuve</label>
                    <input type='date' id='date' placeholder='Date' name='date' required>
                </div>
                <div class='column_4'>
                    <label for='heure'>Heure de l'épreuve</label>
                    <input type='date' id='heure' placeholder='Heure' name='date' required>
                </div>
                <div class='column_4'>
                    <label for='price'>Tarif de l'épreuve</label>
                    <input type='date' id='price' placeholder='Prix' name='price' required>
                </div>
                <div class='row button'>
                    <button name='valider'>Valider</button>
                </div>
                </form>";
    }

    public function edit(){
        return '<h1>Modifier une epreuve : '.$this->data->name.'</h1><hr>
                <form action="#" method="POST"/>
                <label>Titre de l\'epreuve</label><input type="text" name="name" value="'.$this->data->name.'" /><br>
                <label>Description</label><textarea name="description">'.$this->data->description.'</textarea><br>
                <label>Heure de l\'epreuve</label><input type="text" name="date" value="'.$this->data->date.'" /><br>
                 <label>Tarif de l\'epreuve</label><input type="text" name="price" value="'.$this->data->price.'"/><br>
                <input type="submit" name="valider"/>
                </form>';
    }

    public function register(){
        return '<h1>Inscription à '.$this->data->name.'</h1>
                <form action="#" method="POST"/>
                <label>Prénom :</label><input type="text" name="firstName"  required/><br>
                <label>Nom :</label><input type="text" name="lastName" required/><br>
                <label>Mail :</label><input type="text" name="mail" required/><br>
                <label>Date de naissance :</label><input type="text" name="birthDate" required/><br>
                <input type="submit" name="register" value="S\'inscrire"/>
                <button>Clear</button>
                </form>';
    }

    public function all(){
        $html = '<h1>Toutes les activitées :</h1><br>';
        foreach ($this->data as $activity) {
            $html .= $activity->name.' / '.$activity->description.' /'.$activity->price.' / '.$activity->name.'<br>';
        }
        return $html;
    }

    public function result(){
        $data = '';
        foreach ($this->data->getParticipants as $participant) {
                    $data .= '<tr><td>'.$participant->pivot->score.'</td><td>'.$participant->firstName.'</td><td>'.$participant->firstName.'</td><td>'.$participant->birthDay.'</td></tr>';
                }
        return '<section class="row">
                <h1>Résultat généraux de l\'épreuve <small>'.$this->data->name.'</small></h1>
                <form action="#" method="POST"/><label>Recherche</label><input type="text" name="searchQuery"/><input type="submit" name="search" value="Recherche"/></form>
                <table>
                <tr><th>Ranking</th><th>Score</th><th>N°PArticipant</th><th>Nom</th></tr>'.$data.'
                </table>
                </section>';
    }
}
