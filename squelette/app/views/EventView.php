<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 15/11/16
 * Time: 16:55
 */

namespace app\views;


use app\utils\Util;

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
            $startDate = Util::dateToStr($event->startDate, STANDARD_DATE_FORMAT);
            $endDate = Util::dateToStr($event->endDate, STANDARD_DATE_FORMAT);
            $addresse = $event->addresse;
        }
        foreach ($this->data['disciplines'] as $discipline){
            if($relatedDisciplineId && $relatedDisciplineId == $discipline->id){
                $selected = 'selected';
            }else $selected ='';

            $options.="<option value='$discipline->id' $selected>$discipline->name";
        }

        $form = "<div class='page_header row'>
                <h1>$title</h1>
            </div>
            <form action=\"$this->script_name/event/save/\" method='post' >
                <input type='hidden' value='$id' name='id'/>
                <div class='column_4'>
                    <label for='nom'>Nom</label>
                    <input type='text' id='nom' placeholder='Nom' name='name' required value='$name'>
                </div>
                <div class='column_4'>
                    <label for='desc'>Description</label>
                    <textarea maxlength='500' id='desc' placeholder='Description' name='description' required>$description</textarea>
                </div>
                <div class='column_4'>
                    <label for='dateStart'>Date de début (dd-mm-yyyy)</label>
                    <input type='text' id='dateStart' name='startDate' value='$startDate' required>
                </div>
                <div class='column_4'>
                    <label for='dateEnd'>Date de fin (dd-mm-yyyy)</label>
                    <input type='text' id='dateEnd' name='endDate' value='$endDate' required>
                </div>
                <div class='column_4'>
                    <label for='lieu'>Lieu</label>
                    <input type='text' id='lieu' placeholder='Lieu' value='$addresse' required name='addresse'>
                </div>
                <div class='column_4'>
                    <label>Discipline</label>
                    <select name='id_discipline'>$options</select>
                </div>
                <div class='column_4'>
                    <label>Photos</label>
                    <input type='file' />
                </div>
                <div class='row button'>
                    <button class='blue-btn' name='send'>Valider</button>
                    <button class='blue-btn' name='cancel'>Annuler</button>
                </div>
            </form>";
            if(isset($_SESSION['message_form'])){
              $form .=
                        "<div class='danger-alert row'>
                          <span>".$_SESSION['message_form']."</span>
                        </div>";
              unset($_SESSION['message_form']);
            }
            return $form;
    }

    public function openEventDetail(){
        $event = $this->data['events'];
        if(isset($_SESSION['return_button'])){
          $url = $_SESSION['return_button'];
        }else{
          $url = "/event/all/";
        }
        $html = '<div>';
        $modifyBlock =''; $addBlock ='';
        if(Util::isCurrentEventPromoter($event)){
            $actions = $this->generateEventActions($event);
            $modifyBlock = $actions['modify_block'];
            $addBlock = $actions['add_block'];
        }
        $activitiesList = $this->eventActivities();

        $dateStart = $event->startDate;
        $dateStart = explode("-", $dateStart);
        $dateStart = $dateStart['2']."/".$dateStart['1']."/".$dateStart['0'];

        $dateEnd = $event->endDate;
        $dateEnd = explode("-", $dateEnd);
        $dateEnd = $dateEnd['2']."/".$dateEnd['1']."/".$dateEnd['0'];

        $html.=
            "<div class='page_header row'>
                <div class='row'>
                  <form action='$this->script_name/event/all/' class='column_3'>
                    <button class='lightblue_button'>Retour</button>
                  </form>
                  <div class='column_5 buttons_event'>
                        $modifyBlock
                  </div>
                </div>
                <h1>$event->name</h1>
            </div>
            <div class='column_4'>
                <div>
                    <p>Du $dateStart au $dateEnd à $event->addresse</p>
                </div>
                <div class='row'>$event->description</div>
            </div>
            <div class='column_4'>
                <h2>Liste des épreuves</h2>
                <div class='list_epreuve'>
                    <ul class='list'>$activitiesList</ul>
                    $addBlock
                </div>
            </div>
        ";
        return $html.'</div>';
    }

    public function openEvents(){
        $html = '';
        $list = $this->eventLists();
        $id = isset($this->data['promoter_id']) ? $this->data['promoter_id'] : '';
        $html.="
            <div class='page_header row'>
                <h1>Liste des Évenements</h1>
                <div class='row search'>
                  <form action='$this->script_name/event/search/' method='post'>
                  <input type='hidden' value='$id' name='id'/>
                    <input class='column_8' type='text' placeholder='Rechercher un événement' name='searchText'/>
                    <div class='column_8 button'>
                      <button class='blue-btn' name='send'>Rechercher</button>
                    </div>
                  </form>
                </div>
                <div class='row list'>
                    $list
                </div>
                <form action='$this->script_name/event/add/' class='row text-align-center'>
                  <button class='blue-btn'>Nouveau</button>
                </form>
             </div>
        ";
        return $html;
    }

    private function eventLists(){

      $html = "";

        foreach ($this->data['events'] as $event){
            $dateStart = $event->startDate;
            $dateStart = explode("-", $dateStart);
            $dateStart = $dateStart['2']."/".$dateStart['1']."/".$dateStart['0'];

            $dateEnd = $event->endDate;
            $dateEnd = explode("-", $dateEnd);
            $dateEnd = $dateEnd['2']."/".$dateEnd['1']."/".$dateEnd['0'];
            $html.="<div class='ligne row'>

                        <div class='column_4'>
                          <h3>$event->name</h3>
                          <p>Du $dateStart au $dateEnd à $event->addresse</p>
                        </div>
                        <div class='column_4 buttons_list'>
                            <a href='$this->script_name/event/?id=$event->id' class='lightblue_button'>Détails</a>";
                            if(Util::isEventModifyable($event)) {
                                $html .= "<a href='$this->script_name/event/delete/?id=$event->id' class='lightblue_button'>Supprimer</a>";
                            }
                        $html.="</div>
                    </div>";
        }
        return $html;
    }

    private function eventActivities(){
        $html='';
        $event_id = $this->data['events']->id;
        foreach ($this->data['events']->getActivities as $activity){
            $html.="<li class='column_8'>
                    <span class='column_7'>$activity->name</span>
                    <a href='$this->script_name/activity/detail/?id=$activity->id&event_id=$event_id' class='row'>Détails</a>
                </li>";
        }
        return $html;
    }

    private function generateEventActions($event){
        $modifyEventBlock = "<a href='$this->script_name/event/edit/?id=$event->id' class='blue-btn'>Modifier</a>";
        $addEventBlock = '';
        switch ($event->status){
            case EVENT_STATUS_CREATED:{
                $modifyEventBlock .= "<a href='$this->script_name/event/changeStatus/?status=".EVENT_STATUS_VALIDATED."&id=$event->id' class='blue-btn'>Valider</a>";
                break;
            }
            case EVENT_STATUS_VALIDATED:{
                $modifyEventBlock .= "<a href='$this->script_name/event/changeStatus/?status=".EVENT_STATUS_OPEN."&id=$event->id' class='blue-btn'>Ouvrir les inscriptions</a>";
                break;
            }
            case EVENT_STATUS_OPEN:{
                $modifyEventBlock .= "<a href='$this->script_name/event/changeStatus/?status=".EVENT_STATUS_CLOSED."&id=$event->id' class='blue-btn'>Fermer les inscriptions</a>";
                break;
            }
            case EVENT_STATUS_CLOSED:{
                $modifyEventBlock .= "<a href='$this->script_name/event/changeStatus/?status=".EVENT_STATUS_OPEN."&id=$event->id' class='blue-btn'>Ouvrir les inscriptions</a>";
                break;
            }
            default:{
                $modifyEventBlock ='';

            }
        }
            if($event->status != EVENT_STATUS_CLOSED && $event->status != EVENT_STATUS_PUBLISHED){
                $addEventBlock = "<a href='$this->script_name/activity/add/?id=$event->id' class='blue-btn'>Ajouter</a>";
            }

            return ['modify_block'=>$modifyEventBlock, 'add_block'=>$addEventBlock];
    }

}
