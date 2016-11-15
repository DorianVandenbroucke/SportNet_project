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
        }else if($selector == 'events'){

        }
    }

    public function openAddForm(){
        return '
            <h3>Ajouter un évenement</h3>
            <form action="" method="">
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

    public function openEvents(){
        $html = '<ul>';
        foreach ($this->data as $event){
            $html.='<li><a href="#">'.$event->name.'</a></li>';
        }
        return $html.'</ul>';
    }
}