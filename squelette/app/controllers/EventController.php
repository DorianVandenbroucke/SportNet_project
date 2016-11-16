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

    public function addEvent(){
        if($this->auth->logged_in){
            $disciplines = Discipline::all();
            $ev = new EventView(['disciplines' =>$disciplines]);
            $ev->render('addForm');
        }else{
            $defaultView = new DefaultView(NULL);
            $defaultView->render('signinForm');
        }
    }

    public function saveEvent(){
        if($this->auth->logged_in){
            $event = new Event();
            $event->name = $this->request->post['name'];
            $event->description = $this->request->post['description'];
            $event->startDate = date("Y-m-d",strtotime($this->request->post['startDate']));
            $event->endDate = date("Y-m-d",strtotime($this->request->post['endDate']));
            $event->addresse = $this->request->post['addresse'];
            $event->id_discipline = $this->request->post['id_discipline'];
            $event->status = EVENT_STATUS_OPEN;
            $event->id_promoter = $this->auth->promoter->id;
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

    //url /all
    public function findAll(){
        $ev = new EventView(['events' =>Event::all()]);
        $ev->render('allEvents');
    }

    //url /allPromoter
    public function findAllByPromoter(){
        if($this->auth->logged_in){
            $ev = new EventView(['events' =>$this->auth->promoter->getEvents()]);
            $ev->render('allEvents');
        }else{
            $defaultView = new DefaultView(NULL);
            $defaultView->render('signinForm');
        }
    }
}