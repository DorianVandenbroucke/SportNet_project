<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 15/11/16
 * Time: 16:55
 */

namespace app\views;


class EventView extends AbstractView
{

    public function __construct($data)
    {
        parent::__construct($data);
    }

    public function render($selector)
    {
        $main = '';
        if($selector == 'saveEventForm'){
            $main = $this->openSaveForm();
        }else if($selector == 'allEvents'){
            $main = $this->openEvents();
        }else if($selector == 'event'){
            $main = $this->openEventDetail();
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

    public function openSaveForm(){
        $selected ='';$name =''; $description = ''; $startDate=''; $endDate=''; $addresse=''; $action =''; $id='';
        $title = 'Ajouter un événement';$options = '';
        $relatedDisciplineId = false;
        if(isset($this->data['events'])){
            $title = 'Modifier événement';
            $event = $this->data['events'];
            $relatedDisciplineId = $event->getDiscipline->id;
            $id = $event->id;
            $name = $event->name;
            $description = $event->description;
            $startDate = $event->startDate;
            $endDate = $event->endDate;
            $addresse = $event->addresse;
        }
        foreach ($this->data['disciplines'] as $discipline){
            if($relatedDisciplineId && $relatedDisciplineId == $discipline->id){
                $selected = 'selected';
            }else $selected ='';

            $options.="<option value='$discipline->id' $selected>$discipline->name";
        }

        return "<div class='page_header row'>
                <h1>$title</h1>
            </div>
            <form action=\"$this->script_name/event/save/\" method='post' >
                <input type='hidden' value='$id'/>
                <div class='column_4'>
                    <label for='nom'>Nom</label>
                    <input type='text' id='nom' placeholder='Nom' name='name' required value='$name'>
                </div>
                <div class='column_4'>
                    <label for='desc'>Description</label>
                    <textarea maxlength='500' id='desc' placeholder='Description' name='description' required>$description</textarea>
                </div>
                <div class='column_4'>
                    <label for='dateStart'>Date de début</label>
                    <input type='date' id='dateStart' placeholder='Date de début' name='startDate' value='$startDate' required>
                </div>
                <div class='column_4'>
                    <label for='dateEnd'>Date de fin</label>
                    <input type='dateEnd' placeholder='Date de fin' name='endDate' value='$endDate' required>
                </div>
                <div class='column_4'>
                    <label for='lieu'>Lieu</label>
                    <input type='text' id='lieu' placeholder='Lieu' value='$addresse' required>
                </div>
                <div class='column_4'>
                    <label>Discipline</label>
                    <select name='id_discipline '>$options</select>
                </div>
                <div class='column_4'>
                    <label>Photos</label>
                    <input type='file' placeholder='FileUpload'/>
                </div>
                <div class='row button'>
                    <button name='send'>Valider</button>
                    <button name='cancel'>Annuler</button>
                </div>
            </form>
        ";
    }

    public function openEventDetail(){

        if(isset($_SESSION['return_button'])){
          $url = $_SESSION['return_button'];
        }else{
          $url = "/event/all/";
        }

        $html = '<div>';
        $event = $this->data['events'];
        $activitiesList = $this->eventActivities();
        $html.="<div class='page_header row'>
                <a href='$this->script_name".$url."'><button class='blue-btn'>Retour</button></a>
                <h1>$event->name</h1>
            </div>
            <div class='column_4'>
                <div>Date:  $event->startDate    $event->endDate</div>
                <div class='row'>$event->description</div>
            </div>
            <div class='column_4'>
                <h2>Liste des épreuves</h2>
                <div>
                    <ul class='list'>$activitiesList</ul>
                    <a href='$this->script_name/activity/add/?id=$event->id'><button class='blue-btn'>Ajouter</button></a>
                </div>
            </div>
            <div class='row'>
                <a href='$this->script_name/event/edit/?id=$event->id'><button class='blue-btn'>Modifier</button></a>
                <a href='$this->script_name/activity/add'><button class='blue-btn'>Fermer les inscriptions</button></a>
            </div>
        ";
        return $html.'</div>';
    }

    public function openEvents(){
        $html = '';
        $list = $this->eventLists();
        $html.="
            <div class='page_header row'>
                <h1>Listes des Évenements</h1>
<<<<<<< HEAD
                <div class='row'>
                  <form action='$this->script_name/event/search/' method='post'>
                    <input type='text' placeholder='Recherche' name='searchText'/>
                  </form>
                </div>
                <div class='row list'>
=======
                <form action='$this->script_name/event/search/' method='post'>
                    <div class='row'>
                        <div  class='column_5'>
                            <input type='text' placeholder='Recherche' name='searchText'/>
                        </div>
                         <div  class='column_3'>   
                            <button class='btn blue-btn' name='send'>Recherche</button>
                        </div>
                    </div>
                </form>
                <div class='column_8 list'>
>>>>>>> d9f4e6f163587be10dd53e1d6a7aa46eae76c94d
                    $list
                </div>
                <div class='row'>
                  <a href='$this->script_name/event/add/'><button class='blue-btn'>Nouveau</button></a>
                </div>
             </div>
        ";
        return $html;
    }

    private function eventLists(){
        $html = '';
        foreach ($this->data['events'] as $event){
            $html.="<div class='ligne row'>
                        <div class='column_3'>$event->name</div>
                        <div class='column_1'>$event->startDate  $event->endDate</div>
                        <div class='column_3'>
                            <a href='$this->script_name/event/?id=$event->id'><button class='blue-btn'>Details</button></a>
                            <a href='$this->script_name/event/?id=$event->id'><button class='blue-btn'>Supprimer</button></a>
                        </div>
                    </div>";
        }
        return $html;
    }

    private function eventActivities(){
        $html='';
        foreach ($this->data['events']->getActivities as $activity){
            $html.="<li class='column_8'>
                    <span class='column_7'>$activity->name</span>
                    <a href='$this->script_name/activity/detail/?id=$activity->id' class='row'>Détails</a>
                </li>";
        }
        return $html;
    }

}
