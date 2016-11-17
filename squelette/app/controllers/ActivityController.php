<?php

namespace app\controllers;

use app\utils\HttpRequest;
use app\utils\Util;
use app\views\ActivityView;
use app\views\EventView;
use app\views\DefaultView;
use app\views\ParticipantView;
use app\models\Activity;
use app\models\Event;
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

                $date = new \DateTime();
                $date->setTime($this->request->post['startDateH'], $this->request->post['startDateM']);
                $activity->date =  $date;

                $activity->id_event =  $this->request->get['id'];
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

                $date = new \Datetime($this->request->post['startDate']);
                $date->setTime($this->request->post['startDateH'], $this->request->post['startDateM']);
                $activity->date =  $date;

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
            $event = $activity->getEvent;
            $activity->delete();
            header('location:'.$this->request->script_name.'/event/?id='.$event->id);
        }
        $view = new DefaultView($this->request);
        return $view->render('signinForm');
    }

    public function detail()
    {
        $activity = Activity::find($this->request->get['id']);
        $date = new \Datetime($activity->date);
        $activity->date = $date;
        $view = new ActivityView($activity);
        $view->render('detail');
    }

    public function paiement()
    {
        $activity = Activity::find($this->request->get['id']);
        $view = new ActivityView($activity);
        return $view->render('paiement');
    }

    public function validatePaiement()
    {
        $view = new ActivityView('<h1>Paiement accepté</h1>');
        return $view->render('validatePaiement');
    }

    public function register()
    {
        $participant = null;
        if($this->request->post)
        {
            $participants = Participant::all();

            //Parcourir la table participant
            foreach ($participants as $par) {
                if($par->mail == $this->request->post['mail'])
                {
                    $participant = $par;
                }
            }

            //Verifier si le participant existe dans la BD
            if($participant == null)
            {
                $participant = new Participant();
                $participant->mail = $this->request->post['mail'];
                $participant->birthDate = $this->request->post['birthDate'];
                $participant->firstName = $this->request->post['firstName'];
                $participant->lastName = $this->request->post['lastName'];
                $participant->save();
            }

            $activity = Activity::find($this->request->get['id']);
            if(!isset($_SESSION['recap'][$participant->id]))
                $_SESSION['recap'][$participant->id] = [$activity->id];
            else   
                array_push($_SESSION['recap'][$participant->id],$activity->id);   

            return $this->recap($participant->id);
        }
        $activity = Activity::find($this->request->get['id']);
        $view = new ActivityView($activity);
        return $view->render('register');
    }

    public function participants()
    {
        $activity = Activity::find($this->request->get['id']);
        $view = new ActivityView($activity);
        return $view->render('participants');
    }

    public function recap($id){
        var_dump($_SESSION['recap']);
        /*$activities = Participant::find($id)->getActivities;
        $view = new ParticipantView($activities);
        return $view->render('recap');*/
    }


    public function export(){
        $id = $this->request->get['id'];
        if(!empty($id)){
            $activity = Activity::find($id);
           $participants = $activity->getParticipants()->get();
            $fp = fopen('php://memory', 'w');
            foreach ($participants as $participant){
                fputcsv($fp, [$participant->lastName, $participant->birthDate, $participant->mail]);
            }
            fseek($fp,0);
            $date  = Util::dateToStr($activity->date, STANDARD_DATE_FORMAT);
            $filename = $activity->name.'-participants-'.$date;
            header('Content-Type: application/csv');
            header("Content-Disposition: attachment; filename=$filename.csv;");
            fpassthru($fp);
            fclose($fp);

        }
    }

    public function publish(){
        $id = $this->request->get['id'];
        echo $id;
        $av = new ActivityView(Activity::find($id));
        $av->render('publish');
    }

    public function importResult(){
        if($_FILES['fichier']['error']>0){
            echo "Hubo un error al cargar el archivo";
            return;
        }
        $csvFile = $_FILES['fichier']['tmp_name'];
        $csvAsArray = array_map('str_getcsv',file($csvFile));
        var_dump($csvAsArray);
    }

}
