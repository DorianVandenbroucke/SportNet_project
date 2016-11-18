<?php

namespace app\views;


class ParticipantView extends AbstractView
{

    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function render($selector)
    {
        switch ($selector) {
            case 'recap':
                $main = $this->recap();
                break;
            case 'participants':
                $main = $this->participants();
                break;
            case 'paiement':
                $main = $this->paiement();
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

    public function recap(){
        $html = "<div class='page_header row'>
                    <h1>Récapitulatif des inscriptions :</h1>
                    <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Epreuve</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Tarif</th>
                            <th></th>
                        </tr>
                    </thead>";

        foreach ($_SESSION['recap'] as $inscription) {

            $dateStart = substr($inscription->activity_date,0,10);
            $dateStart = explode("-", $dateStart);
            $dateStart = $dateStart['2']."/".$dateStart['1']."/".$dateStart['0'];

            $html .= "<tr>
            <td style='padding:10px'>".$inscription->participant_lastname." ".$inscription->participant_firstname."</td>
            <td style='padding:10px'>".$inscription->activity_name." </td>
            <td style='padding:10px'>".$dateStart." </td>
            <td style='padding:10px'>".substr($inscription->activity_date,10,6)." </td>
            <td style='padding:10px'>".$inscription->activity_tarif." </td>
            <td style='padding:10px'><a href='".$this->script_name."/recapitulatif/?idact=".$inscription->activity_id."&idPar=".$inscription->participant_id."'/>Supprimer</a></td></tr>";
        }

        if(isset($inscription))
            {
                $html .= "</table>
                <div class='paiement'>"." <a href='".$this->script_name."/event/?id=".$inscription->event_id."' class='blue-btn'>Continuer les inscriptions</a>";
                }
        else
            {
                $html .= "</table>
                <div class='paiement'>"." <a href='".$this->script_name."/event/all' class='blue-btn'>Continuer les inscriptions</a>";
            }

        $html .= "<a href='".$this->script_name."/paiement/' class='blue-btn'>Paiement</a>
        </div>";
        return $html;
    }

    public function paiement(){
        return "<div class='page_header row'>
                    <h1>Paiement</h1>
                </div>
                    <form action='$this->script_name/validatePaiement/' method='post'>
                        <div class='column_4'>
                            <label for='nom'>Titulaire de la carte</label>
                            <input type='text' id='nom'/>
                        </div>
                        <div class='column_4'>
                            <label for='num'>Numéro de carte</label>
                            <input type='number' id='num'/>
                        </div>
                        <div class='column_4'>
                            <label for='crypto'>Cryptogramme</label>
                            <input type='number' id='crypto'/>
                        </div>
                        <div class='row button'>
                            <button class='blue-btn'>Valider</button>
                        </div>
                    </form>";
    }

    public function validatePaiment(){

    }

    public function participants(){
        $data = '';
        if(!isset($this->data['activity_id'])){
            //error
        }else{
            $id = $this->data['activity_id'];
            foreach ($this->data['participants'] as $participant) {
                $data .= '<tr>
                                <td>'.$participant->lastName.' '.$participant->firstName.'</td>
                                <td>'.$participant->id.'</td>
                                <td>'.$participant->mail.'</td>
                                <td>'.$participant->birthDate.'</td>
                              </tr>';
            }
            return '<section class="row">
                <h1>Participants de l\'épreuve <small>'.$this->data['activity_name'].'</small></h1>
                <form action="'.$this->script_name.'/activity/searchParticipants/" method="POST"/>
                    <input type="hidden" name="id" value="'.$id.'"/>
                    <input type="text" name="searchQuery" placeholder="Recherche"/>
                    <div class="row button">
                        <button class="blue-btn" name="search">Recherche</button>
                    </div>
                </form>
                <table>
                    <thead>
                        <tr><th>Nom</th><th>Nº du participant</th><th>E-mail</th><th>Date de naissance</th></tr>
                    </thead>
                    <tbody>
                        '.$data.'
                    </tbody>
                </table>
                <div class="export">
                    <a href="'.$this->script_name.'/activity/export/?id='.$id.'". class="blue-btn row">Exporter CSV</a>
                </div>
                </section>';
        }

    }

}
