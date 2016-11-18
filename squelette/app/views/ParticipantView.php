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
        $html = "<h1>Récapitulatif des inscriptions :</h1><table>";
        foreach ($this->data as $inscription) {
            $html .= "<tr><td style='padding:10px'>".$inscription->participant_name." </td>
            <td style='padding:10px'>".$inscription->activity_name." </td>
            <td style='padding:10px'>".substr($inscription->activity_date,0,10)." </td>
            <td style='padding:10px'>".substr($inscription->activity_date,10,6)." </td>
            <td style='padding:10px'>".$inscription->activity_tarif." </td></tr>";
        }
        $html .= "</table><div class='paiement'><a href='".$this->script_name."/paiement/' class='blue-btn'>Paiement</a></div>";
        return $html;
    }

    public function paiement(){
        return '<h1>'.$this->data.'</h1>';
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
                                <td class="text-align-center">'.$participant->id.'</td>
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
                        <tr><th>Nom</th><th>Nº Participant</th><th>Email</th><th>Birthdate</th></tr>
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
