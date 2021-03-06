<?php

/**
 * Created by PhpStorm.
 * User: marco
 * Date: 15/11/16
 * Time: 15:36
 */
namespace app\controllers;

use app\models\Discipline;
use app\models\Event;
use app\utils\Authentification;
use app\utils\HttpRequest;
use app\utils\Util;
use app\views\DefaultView;
use app\views\EventView;

class EventController extends AbstractController
{
    private $request = null;
    private $auth;

    public function __construct(HttpRequest $httpRequest)
    {
        $this->request = $httpRequest;
        $this->auth = new Authentification();
    }

    public function saveEventForm(){
        if($this->auth->logged_in){
            $disciplines = Discipline::all();
            if(isset($this->request->get['id'])){//edit
                $event = Event::find($this->request->get['id']);
                $ev = new EventView(['events'=>$event, 'disciplines'=>$disciplines]);
            }else{//add
                $ev = new EventView(['disciplines' =>$disciplines]);
            }
            $ev->render('saveEventForm');
        }else{
            $defaultView = new DefaultView(NULL);
            $defaultView->render('signinForm');
        }
    }

    public function saveEvent(){


        if($this->auth->logged_in){
            $id = $this->request->post['id'];
            if(isset($this->request->post['cancel'])){
                $this->redirectTo("../?id=$id");
            }else{
                $redirectParam = empty($id) ? '' : "?id=$id";
                $event = empty($id) ? new Event() : Event::find($id);
                $event->name = $this->request->post['name'];
                $event->description = filter_var($this->request->post['description'], FILTER_SANITIZE_SPECIAL_CHARS);
                if(!Util::isDateValid($this->request->post['startDate']) || !Util::isDateValid($this->request->post['endDate'])){
                    $this->redirectTo($this->request->script_name."/event/add/".$redirectParam);
                    $_SESSION['message_form'] = "Le format des dates est incorrect";
                    return;
                }
                $event->startDate = Util::strToDate($this->request->post['startDate'], MYSQL_DATE_FORMAT);
                $event->endDate = Util::strToDate($this->request->post['endDate'], MYSQL_DATE_FORMAT);
                $event->addresse = $this->request->post['addresse'];
                $event->id_discipline = $this->request->post['id_discipline'];
                if(empty($id)) {
                    $event->status = EVENT_STATUS_CREATED;
                    $event->id_promoter = $this->auth->promoter;
                }
                if($event->save()) {
                    $this->redirectTo("../?id=$event->id");
                }else{
                    $this->redirectTo($this->request->script_name."/event/add/".$redirectParam);
                }
            }
        }else{
            $defaultView = new DefaultView(NULL);
            $defaultView->render('signinForm');
        }

    }

    public function deleteEvent(){
        $id = $this->request->get['id'];
        $totalDeleted = Event::destroy($id);
        $this->redirectTo("../all/?id=$_SESSION[promoter]");

    }

    public function updateEvent(){
        $event = Event::find($this->request->post['id']);
        $event->name = $this->request->post['name'];
        $event->description = $this->request->post['description'];
        $event->startDate = $this->request->post['startDate'];
        $event->endDate = $this->request->post['endDate'];
        $event->update();
    }

    //
    public function detailEvent(){
        $id = $this->request->get['id'];
        $event = Event::find($id);

        if($event){
            $ev = new EventView(['events' =>$event]);
            $ev->render('event');
        }
    }

    public function findAll(){
        if(isset($this->request->get['id'])){
            $id = $this->request->get['id'];
            $events = Event::select()->where('id_promoter',$id)->get();
            $ev = new EventView(['events' =>$events, 'promoter_id'=>$id]);
        }else{
            $ev = new EventView(['events' =>Event::select()->where('status', '!=',0)->get()]);
        }
        $ev->render('allEvents');
    }

    public function search(){
            $searchText = filter_var(trim($this->request->post['searchText']),FILTER_SANITIZE_STRING);
            $searchText = empty($searchText) ? '%' : "%$searchText%";
            $id = $this->request->post['id'];
            if(!empty($id)){
                $events = Event::where('name','like',$searchText)->where('id_promoter','=',$this->auth->promoter)->get();
            }else{
                $events = Event::where('name','like',$searchText)->get();
            }
            $ev = new EventView(['events' =>$events]);
            $ev->render('allEvents');
    }

    public function changeStatus(){
        if($this->auth->logged_in){
            $id = $this->request->get['id'];
            $status = $this->request->get['status'];
            $event = Event::find($id);
            $event->status = $status;
            $event->update();
            $this->redirectTo("../?id=$id");
        }else{
            $defaultView = new DefaultView(NULL);
            $defaultView->render('signinForm');
        }
    }

}
