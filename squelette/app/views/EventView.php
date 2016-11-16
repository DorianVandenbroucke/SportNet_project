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
        if($selector == 'addForm'){
            $main = $this->openAddForm();
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

    public function openAddForm(){

        return '
            <h3>Ajouter un évenement</h3>
            <form action="$this->script_name/event/save/" method="post" >
                <div><label for="nom">Nom</label><input type="text" id="nom" placeholder="Nom" name="name"></div>
                <div><label for="desc">Description</label><textarea maxlength="500" id="desc" placeholder="Description" name="description"></textarea></div>
                <div><label for="date">Dates</label><input type="date" id="date" placeholder="Date de début" name="startDate"><input type="date" placeholder="Date de fin" name="endDate"></div>
                <div><label for="lieu">Lieu</label><input type="text" id="lieu" placeholder="Lieu"></div>
                <div><label>Discipline</label><select>
                                                <option>Marathon</option>
                                                <option>Vélo</option>
                                            </select></div>
                <div><label>Photos</label><input type="file" placeholder="FileUpload"/></div>
                <div><input type="submit" value="Valider"></div>
            </form>
        ';
    }

    public function openEventDetail(){
        $html = '<div>';
        $event = $this->data['events'];
        $activitiesList = $this->eventActivities();
        $html.="
            <h2>$event->name</h2>
            <div>
                <div>Date:  $event->startDate    $event->endDate</div>
                <div>$event->description</div>
                <div>
                    <h2>Liste des épreuves</h2>
                    <div>
                        <ul>$activitiesList</ul>
                        <a href='$this->script_name/activity/add/'>Ajouter</a>
                    </div>
                </div>
            </div>
            <div><a href='$this->script_name/event/edit/?id=$event->id'>Modifier</a><a href='$this->script_name/activity/add'>Fermer les inscriptions</a></div>
        ";
        return $html.'</div>';
    }

    public function openEvents(){
        $html = '';
        $list = $this->eventLists();
        $html.="
            <div>
                <h2>Listes des Évenements</h2>
                <form action='$this->script_name/event/search/' method='post'><input type='text' placeholder='Recherche' name='searchText'/></form>
                <div>
                    <ul>$list</ul>
                </div>
                <div><a href='$this->script_name/event/add/'>Nouveau</a></div>
             </div>
        ";
        return $html;
    }

    private function eventLists(){
        $html = '';
        foreach ($this->data as $event){
            $html.="<li>$event->nom    $event->startDate - $event->endDate
                <a  href='$this->script_name/event/detail/?id=$event->id'>Details</a>
                <a href='$this->script_name/event/delete/?id=$event->id'>Supprimer</a>
                </li>";
        }
        return $html;
    }

    private function eventActivities(){
        $html='';
        foreach ($this->data->getActivities() as $activity){
            $html.="<li>$activity->nom
                <a  href='$this->script_name/activity/detail/?id=$activity->id'>Détail</a>
                </li>";
        }
        return $html;
    }

}
