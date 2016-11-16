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
        if($selector == 'addForm'){
            return $this->openAddForm();
        }else if($selector == 'allEvents'){
            return $this->openEvents();
        }else if($selector == 'event'){
            return $this->openEventDetail();
        }
    }

    public function openAddForm(){

        return '
            <h3>Ajouter un évenement</h3>
            <form action="$this->script_name/event/save/" method="post" >
                <div><label>Nom</label><input type="text" placeholder="Nom" name="name"/></div>
                <div><label>Description</label><textarea  placeholder="Description" name="description"/></div>
                <div><label>Dates</label><input type="date" name="startDate"/><input type="date" name="endDate"/></div>
                <div><label>Lieu</label><input type="text" placeholder="Lieu"/></div>
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
        $event = $this->data;
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