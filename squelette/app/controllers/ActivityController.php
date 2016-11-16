<?php

namespace app\controllers;

use app\utils\HttpRequest;
use app\views\ActivityView;
use app\views\DefaultView;
use app\models\Activity;
use app\models\Event;
use app\views\EventView;
use app\models\Participant;
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
                $activity->description =  $this->request->post['description'];
                $activity->price = $this->request->post['price'];
                $activity->date =  $this->request->post['date'];
                $activity->id_event=  $this->request->get['id'];
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

    public function update()
    {
        if($this->auth->logged_in)
        {
            $activity = Activity::find($this->request->get['id']);
            if($this->request->post)
            {
                $activity->name = $this->request->post['name'];
                $activity->description=  $this->request->post['description'];
                $activity->date=  $this->request->post['date'];

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

    public function delete()
    {
        if($this->auth->logged_in)
        {
            $activity = Activity::find($this->request->get['id']);
            $event = $activity->getEvent();
            $activity->delete();
            $view = new EventView($event);
            return $view->render('detailEvent');
        }
        $view = new DefaultView($this->request);
        return $view->render('signinForm');
    }

    public function detail()
    {
        $activity = Activity::find($this->request->get['id']);
        $view = new ActivityView($activity);
        $view->render('detail');
    }

    public function paiement()
    {
        $view = new ActivityView($this->request);
        return $view->render('paiement');
    }

    public function register()
    {
        if($this->request->post)
        {
            $participant = new Participant();
            $participant->mail = $this->request->post['mail'];
            $participant->birthDate = $this->request->post['birthDate'];
            $participant->firstName = $this->request->post['firstName'];
            $participant->lastName = $this->request->post['lastName'];
            $participant->save();

            $activity = Activity::find($this->request->get['id']);
            $activity->getParticipants()->attach($participant);
            $view = new ActivityView($activity);
            return $view->render('detail');
        }
        $activity = Activity::find($this->request->get['id']);
        $view = new ActivityView($activity);
        return $view->render('register');
    }

    public function result()
    {
        $activity = Activity::find($this->request->get['id']);
        $view = new ActivityView($activity);
        return $view->render('result');
    }

}
