<?php

namespace app\controllers;

use app\utils\HttpRequest;
use app\views\ActivityView;
use app\models\Activity;
use app\models\Event;
use app\modelsParticipant;
use app\utils\Authentification;

class ActivityController{

    private $request = null;
    private $auth;

    public function __construct(HttpRequest $http_req)
    {
        $this->request = $http_req;
        $this->auth = new Authentification();
    }

    public function add()
    {
        if($this->auth->logged_in)
        {
            if($this->request->post)
            {
                $activity = new Activity();
                $activity->name = $this->request->post['name'];
                $activity->description=  $this->request->post['description'];
                $activity->date=  $this->request->post['date'];
                $activity->id_event=  $this->request->post['id_event'];

                $activity->save();

                $view = new ActivityView($activity);
                return $view->render('detail');
            }
            $view = new ActivityView($this->request);
            return $view->render('add');
        }
        $view = new DefaultView($this->request);
        return $view->render('signinForm');
    }

    public function update($id)
    {
        if($this->auth->logged_in)
        {
            $activity = Activity::find($id);
            if($this->request->post)
            {
                $activity->name = $this->request->post['name'];
                $activity->description=  $this->request->post['description'];
                $activity->date=  $this->request->post['date'];
                $activity->id_event=  $this->request->post['id_event'];

                $activity->save();

                $view = new ActivityView($activity);
                return $view->render('detail');
            }
            $view = new ActivityView($activity);
            return $view->render('edit');
        }
        $view = new DefaultView($this->request);
        return $view->render('signinForm');
    }

    public function delete($id)
    {
        if($this->auth->logged_in)
        {
            $activity = Activity::find($id);
            $activity->delete();
            return $this->all();  
        }
        $view = new DefaultView($this->request);
        return $view->render('signinForm');
    }

    public function detail($id)
    {
        $event = Activity::find($idEvent);
        $view = new ActivityView($activities);
        $view->render('detail');
    }

    public function paiement()
    {
        $view = new ActivityView($this->request);
        return $view->render('paiement');
    }

    public function register($id)
    {
        if(!$this->request->post)
        {
            $view = new ActivityView($this->request);
            return $view->render('register');
        }

        $participant = new Participant();
        $participant->mail = $this->request->post['mail'];
        $participant->birthDate = $this->request->post['birthDate'];
        $participant->firstName = $this->request->post['firstName'];
        $participant->lastName = $this->request->post['lastName'];
        $participant->save();
        
        $activity = Activity::find($id);
        $activity->getParticipants()->attach($participant);
        $view = new ActivityView($id);
        return $view->render('detail');
    }

    public function result($id)
    {
        $activity = Activity::find($id)->with('getParticipants')->get();
        $view = new ActivityView($activity);
        return $view->render('result');
    }
} 