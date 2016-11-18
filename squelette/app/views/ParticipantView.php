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
        $html = '<section>';
        foreach ($this->data as $inscription) {
                     $html .= ' nom: '.$inscription->name.'<br>date: '.substr($inscription->date,0,10).'<br> heure :'.substr($inscription->date,10,6).'<br> price: '.$inscription->price.'<hr>';
        }   
        $html .='</section>';
        return $html;
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
                    <input type="submit" name="search" value="Recherche"/>
                </form>
                <table>
                    <thead>
                        <tr><th>Nom</th><th>Nº Participant</th><th>Email</th><th>Birthdate</th></tr>
                    </thead>
                    <tbody>
                        '.$data.'
                    </tbody>
                </table>
                <a href="'.$this->script_name.'/activity/export/?id='.$id.'".><button>Exporter CSV</button></a>
                </section>';
        }

    }

}