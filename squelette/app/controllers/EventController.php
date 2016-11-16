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
use app\models\Promoter;
use app\utils\Authentification;
use app\utils\HttpRequest;
use app\views\DefaultView;
use app\views\EventView;

class EventController
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
        $id = $this->request->post['id'];
        if($this->auth->logged_in){
            $event = empty($id) ? new Event() : Event::find($id);
            $event->name = $this->request->post['name'];
            $event->description = $this->request->post['description'];
            $event->startDate = date("Y-m-d",strtotime($this->request->post['startDate']));
            $event->endDate = date("Y-m-d",strtotime($this->request->post['endDate']));
            $event->addresse = $this->request->post['addresse'];
            $event->id_discipline = $this->request->post['id_discipline'];
            $event->status = EVENT_STATUS_OPEN;
            if(empty($id))
                $event->id_promoter = $this->auth->promoter;

            if($event->save()){
                $ev = new EventView(['events' =>$event]);
                $ev->render('event');
            }
        }else{
            $defaultView = new DefaultView(NULL);
            $defaultView->render('signinForm');
        }

    }

    public function deleteEvent(){
        $id = $this->request->get['id'];
        $totalDeleted = Event::destroy($id);
        var_dump($totalDeleted);
        $this->findAllByPromoter();

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
            $ev = new EventView(['events' =>$events]);
        }else{
            $ev = new EventView(['events' =>Event::all()]);
        }
        $ev->render('allEvents');
    }
}
