<?php

namespace app\views;

use app\utils\Util;
use app\models\Event;

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
            case 'results':
                $main = $this->results();
                break;
            case 'paiement':
                $main = $this->paiement();
                break;
            case 'validatePaiement':
                $main = $this->validatePaiement();
                break;
            case 'publish':
                $main = $this->publish();
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
        $event = Event::find($this->data->id_event);
        $modifyBlock='';$actionBlock='';
        $optionArray = $this->generateactivityActions($event->status);
        if(Util::isCurrentEventPromoter($event)){
            $modifyBlock = $optionArray['modify_block'];
        }
        $actionBlock = empty($optionArray['action_block']) ? '' : "<section class='row column_5 part_link text-align-center'>$optionArray[action_block]</section>";
        $html =
            '<div class="page_header row" >
                <div class="row">
                    <form class="column_3" method="GET" action="'.$this->script_name.'/event/">
                      <input type="hidden" name="id" value="'.$_GET['event_id'].'" />
                      <button class="lightblue_button">Retour</button>
                    </form>
                    <div class="column_5 buttons_event">'.
                          $modifyBlock.'
                    </div>
                </div>
                <h1>'.$this->data->name.'</h1>
            </div>
            <section>
                <section class="column_5">
                    <p>'.$this->data->description.'</p><br>
                </section>
                <aside class="column_3">
                    <div>
                        <ul class="list-without-style">
                            <li><strong>Date de l\'épreuve :</strong></li>
                            <li>'.$this->data->date->format('d/m/Y').'</li>
                            <li><strong>Heure de l\'épreuve :</strong></li>
                            <li>'.$this->data->date->format('H:i').'</li>
                            <li><strong>Tarif de l\'épreuve :</strong></li>
                            <li>'.$this->data->price.' €</li>
                        </ul>
                    </div>
                </aside>
           </section>
            '.$actionBlock;
           return $html;
    }

    public function add(){
        return "
                <div class='page_header row'>
                  <form class='column_3' action='$this->script_name".$_SESSION['return_button']."'>
                    <button class='lightblue_button'>Retour</button>
                  </form>
                    <h1>Ajouter une épreuve</h1>
                </div>
                <form action='#' method='POST'>
                <div class='column_4'>
                    <label for='nom'>Titre de l'épreuve</label>
                    <input type='text' id='nom' placeholder='Nom' name='name'  >
                </div>
                <div class='column_4'>
                    <label for='desc'>Description</label>
                    <textarea id='desc' name='description'></textarea>
                </div>
                <div class='column_4'>
                    <label for='date'>Date de l'épreuve (dd-mm-yyyy)</label>
                    <input type='date' id='date' name='startDate'  >
                </div>
                <div class='column_4'>
                    <label for='heure'>Heure de l'épreuve (hh:mm)</label><br>
                    <input type='text' id='heure' class='heure' placeholder='hh' name='startDateH'>
                    <input type='text' class='heure' placeholder='mm' name='startDateM'>
                </div>
                <div class='column_4'>
                    <label for='price'>Tarif de l'épreuve (en €)</label>
                    <input type='number' id='price' placeholder='Prix' name='price'  >
                </div>
                <div class='row button'>
                    <button class='blue-btn' name='valider'>Valider</button>
                </div>
                </form>";
    }

    public function edit(){
         return "<div class='page_header row'>
           <div class='row'>
             <a href='$this->script_name".$_SESSION['return_button']."' class='lightblue_button'>Retour</a>
           </div>
                    <h1>Modifier : ".$this->data->name."</h1>
                </div>
                <form action='#' method='POST'>
                <div class='column_4'>
                    <label for='nom'>Titre de l'épreuve</label>
                    <input type='text' id='nom' placeholder='Nom' name='name' value=".$this->data->name."  >
                </div>
                <div class='column_4'>
                    <label for='desc'>Description</label>
                    <textarea id='desc' name='description'>".$this->data->description."</textarea>
                </div>
                <div class='column_4'>
                    <label for='date'>Date de l'épreuve (dd-mm-yyyy)</label>
                    <input type='date' id='date' name='startDate' value=".$this->data->date."  >
                </div>
                <div class='column_4'>
                    <label for='heure'>Heure de l'épreuve (hh:mm)</label><br>
                    <input type='text' id='heure' class='heure' placeholder='hh' name='startDateH' value=".substr($this->data->date,11,2)." >
                    <input type='text' class='heure' placeholder='mm' name='startDateM' value=".substr($this->data->date,14,2)." >
                </div>
                <div class='column_4'>
                    <label for='price'>Tarif de l'épreuve (en €)</label>
                    <input type='number' id='price' placeholder='Prix' name='price' value=".$this->data->price." >
                </div>
                <div class='row button'>
                    <button class='blue-btn' name='valider'>Valider</button>
                </div>
                </form>";
    }

    public function register(){
        return "<div class='page_header row'>
                    <h1>Inscription à ".$this->data->name."</h1>
                </div>
                <form action='#' method='POST'>
                <div class='column_4'>
                    <label for='firstName'>Prénom</label>
                    <input type='text' id='firstName' placeholder='Prénom' name='firstName'  >
                </div>
                <div class='column_4'>
                    <label for='lastName'>Nom</label>
                    <input type='text' id='lastName' placeholder='Nom' name='lastName'  >
                </div>
                <div class='column_4'>
                    <label for='mail'>Mail</label>
                    <input type='mail' id='mail' placeholder='Mail' name='mail'  >
                </div>
                <div class='column_4'>
                    <label for='birthDate'>Date de naissance</label>
                    <input type='text' id='birthDate' placeholder='dd-mm-yyyy' name='birthDate'  >
                </div>
                <div class='row button'>
                    <button class='blue-btn' name='register'>S'inscrire</button>
                    <button class='blue-btn' name='cancel'>Annuler</button>
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

    public function results(){
        $data = '';
        $id = $this->data->id;
        foreach ($this->data->getParticipants as $participant) {
                    $data .= '<tr>
                                <td>'.$participant->lastName.' '.$participant->firstName.'</td>
                                <td class="text-align-center">'.$participant->pivot->participant_number.'</td>
                                <td>'.$participant->mail.'</td>
                                <td>'.$participant->pivot->ranking.'</td>
                                <td>'.$participant->pivot->score.'</td>
                              </tr>';
                }
        return '<section class="row">
                <h1>Résultats de l\'épreuve <small>'.$this->data->name.'</small></h1>
                <form action="'.$this->script_name.'searchParticipants/" method="POST"/>
                    <input type="hidden" name="id" value="'.$id.'"/>
                    <input type="text" name="searchQuery"/>
                    <input type="submit" name="search" value="Recherche"/>
                </form>
                <table>
                    <thead>
                        <tr><th>Nom</th><th>Nº Participant</th><th>Email</th><th>Ranking</th><th>Score</th></tr>
                    </thead>
                    <tbody>
                        '.$data.'
                    </tbody>
                </table>
                <a href="'.$this->script_name.'/activity/export/?id='.$this->data->id.'".><button>Exporter CSV</button></a>
                </section>';
    }

    public function paiement(){
        return "<h1>Paiement</h1>
                <h2> Montant de la transaction : ".$this->data->price."</h2>
                Numéro de la carte : <input type='text'/><br>
                Date d'expiration : <input type='text'/><br>
                Code de vérification : <input type='text'/><br>
                <a href='".$this->script_name."/validatePaiment/' type='submit' name='paiment' />Valider</a>
                ";
    }

    public function validatePaiement()
    {
        return $this->data;
    }

    public function publish(){
        $id = $this->data->id;
        $html =
            "<div class='page_header row' >
                <div class='row'>
                  <a href='$this->script_name/activity/detail/?id=$id'><button class='lightblue_button'>Retour</a>
                </div>
                <h1>Publier les résultats</h1>
            </div>
            <section>
                <section class='column_8'>
                    <form enctype='multipart/form-data' action='$this->script_name/activity/importResult/' method='post'>
                        <input type='hidden' name='id' value='$id'/>
                        <label for='fichier'>Ajout du fichier CSV</label>
                        <input type='file' accept='text/csv' name='fichier' class='text-align-center' id='fichier' required >

                        <div class='row button'>
                            <button class='blue-btn send' name='send'>Upload</button>
                        </div>
                    </form>
                </section>

           </section>";
        return $html;
    }


    private function generateactivityActions($status){
        $modifyBlock = ''; $actionBlock ='';

        if($status != EVENT_STATUS_PUBLISHED){
            if($status == EVENT_STATUS_CLOSED){
                $modifyBlock.= '<a href="'.$this->script_name.'/activity/publish/?id='.$this->data->id.'" class="blue-btn row">Publier les résultats</a>';
            }
            $modifyBlock.='<a href="'.$this->script_name.'/activity/edit/?id='.$this->data->id.'" class="blue-btn  row">Modifier</a>
                <a href="'.$this->script_name.'/activity/delete/?id='.$this->data->id.'" class="blue-btn row">Supprimer</a>';
        }
        if($status != EVENT_STATUS_VALIDATED && $status != EVENT_STATUS_CREATED){
            if($status == EVENT_STATUS_OPEN){
                $actionBlock.= '<a href="'.$this->script_name.'/activity/register/?id='.$this->data->id.'" class="blue-btn">S\'inscrire</a>';
            }
            $actionBlock.='<a href="'.$this->script_name.'/activity/participants/?id='.$this->data->id.'" class="blue-btn">Voir Participants</a>';
            if($status == EVENT_STATUS_PUBLISHED){
                $actionBlock.='<a href="'.$this->script_name.'/activity/result/?id='.$this->data->id.'" class="blue-btn">Voir Résultats</a>';
            }
        }

        return ['modify_block'=>$modifyBlock, 'action_block'=>$actionBlock];
    }
}
