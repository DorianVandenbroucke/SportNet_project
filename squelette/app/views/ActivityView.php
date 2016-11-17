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
        return '<div class="page_header row">
                <h1>'.$this->data->name.'</h1>
            </div>
            <section>
                <section class="column_5">
                    <p>'.$this->data->description.'</p><br>
                </section>
                <aside class="column_3">
                <a href="#"><button class="blue-btn column_3 row">Publier les résultats</button></a><br>
                <a href="'.$this->script_name.'/activity/edit/?id='.$this->data->id.'"><button class="blue-btn column_3 row">Modifier</button></a><br>
                <a href="'.$this->script_name.'/activity/delete/?id='.$this->data->id.'"><button class="blue-btn column_3 row">Supprimer</button></a><br>
                <div>
                    <h5>Date de l\'épreuve : '.$this->data->date->format('Y-m-d').'</h5>
                    <h5>Heure de l\'épreuve : '.$this->data->date->format('H:i').'</h5>
                </div>
                </aside>
           </section>
           <section class="row offset_1">
                <a href="'.$this->script_name.'/activity/register/?id='.$this->data->id.'"><button class="blue-btn column_2">S\'inscrire</button></a>
                <a href="'.$this->script_name.'/activity/result/?id='.$this->data->id.'"><button class="blue-btn column_2">Résultats</button></a>
           </section>';
    }

    public function add(){
        return "<div class='page_header row'>
                    <h1>Ajouter une épreuve</h1>
                </div>
                <form action='#' method='POST'/>
                <div class='column_4'>
                    <label for='nom'>Titre de l'épreuve</label>
                    <input type='text' id='nom' placeholder='Nom' name='name'  >
                </div>
                <div class='column_4'>
                    <label for='desc'>Description</label>
                    <textarea id='desc' name='description'></textarea>
                </div>
                <div class='column_4'>
                    <label for='date'>Date de l'épreuve</label>
                    <input type='date' id='date' placeholder='Date' name='startDate'  >
                </div>
                <div class='column_4'>
                    <label for='heure'>Heure de l'épreuve</label>
                    <input type='text' id='heure' placeholder='Heure' name='startDateH'  >
                    <input type='text' id='heure' placeholder='Heure' name='startDateM'  >
                </div>
                <div class='column_4'>
                    <label for='price'>Tarif de l'épreuve</label>
                    <input type='text' id='price' placeholder='Prix' name='price'  >
                </div>
                <div class='row button'>
                    <button name='valider'>Valider</button>
                </div>
                </form>";
    }

    public function edit(){
         return "<div class='page_header row'>
                    <h1>Modifier : ".$this->data->name."</h1>
                </div>
                <form action='#' method='POST'/>
                <div class='column_4'>
                    <label for='nom'>Titre de l'épreuve</label>
                    <input type='text' id='nom' placeholder='Nom' name='name' value=".$this->data->name."  >
                </div>
                <div class='column_4'>
                    <label for='desc'>Description</label>
                    <textarea id='desc' name='description'>".$this->data->description."</textarea>
                </div>
                <div class='column_4'>
                    <label for='date'>Date de l'épreuve</label>
                    <input type='date' id='date' placeholder='DD-MM-YYYY' name='startDate' value=".$this->data->date."  >
                </div>
                <div class='column_4'>
                    <label for='heure'>Heure de l'épreuve</label><br>
                    <input type='text' id='heure' class='heure' placeholder='HH' name='startDateH' value=".substr($this->data->date,11,2)." >
                    <input type='text' class='heure' placeholder='MM' name='startDateM' value=".substr($this->data->date,14,2)." >
                </div>
                <div class='column_4'>
                    <label for='price'>Tarif de l'épreuve</label>
                    <input type='text' id='price' placeholder='Prix' name='price' value=".$this->data->price." >
                </div>
                <div class='row button'>
                    <button name='valider'>Valider</button>
                </div>
                </form>";
    }

    public function register(){
        return "<div class='page_header row'>
                    <h1>Inscription à ".$this->data->name."</h1>
                </div>
                <form action='#' method='POST'/>
                <div class='column_4'>
                    <label for='firstName'>Prénom</label>
                    <input type='text' id='firstName' placeholder='Prénom' name='firstName'  >
                </div>
                <div class='column_4'>
                    <label for='lastName'>Nom</label>
                    <input type='text' id='lastName' placeholder='Nom' name='lastName'  >
                </div>
                <div class='column_4'>
                    <label for='mail'>Nom</label>
                    <input type='mail' id='mail' placeholder='Nom' name='mail'  >
                </div>
                <div class='column_4'>
                    <label for='birthDate'>Date de naissance</label>
                    <input type='text' id='birthDate' placeholder='Date de naissance' name='birthDate'  >
                </div>
                <div class='row button'>
                    <button name='register'>S'inscrire</button>
                    <button name='cancel'>Annuler</button>
                </div>
                </form>";
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
