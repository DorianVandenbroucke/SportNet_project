<?php

/**
 * Created by PhpStorm.
 * User: marco
 * Date: 15/11/16
 * Time: 15:36
 */
namespace app\controllers;

use app\models\Event;
use app\utils\Authentification;
use app\utils\HttpRequest;

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
            //TODO open EventView, addEvent form
        }else{
            //TODO redirect to login
        }
    }

    public function saveEvent(){
        $event = new Event();
        $event->name = $this->request->post['name'];
        $event->description = $this->request->post['description'];
        $event->startDate = $this->request->post['startDate'];
        $event->addresse = $this->request->post['addresse'];
        $event->endDate = $this->request->post['endDate'];
        $event->id_discipline = $this->request->post['id_discipline'];
        $event->id_promoter = $this->auth->promoter->id;
        $event->save();
        $id = $event->id;
        //redirect to events view

    }

    public function deleteEvent(){
        $id = $this->request->get['id'];
        $totalDeleted = Event::destroy($id);
        return $totalDeleted > 0;
    }

    public function updateEvent(){
        $event = new Event();
        $event->id = $this->request->post['id'];
        $event->name = $this->request->post['name'];
        $event->description = $this->request->post['description'];
        $event->startDate = $this->request->post['startDate'];
        $event->endDate = $this->request->post['endDate'];
        $event->update();
    }

    public function findById(){
        $id = $this->request->get['id'];
        return Event::find($id);
    }

    public function findAll(){
        return Event::all();
    }

    public function findAllByPromoter(){
        return $this->auth->promoter->getEvents();
    }
}