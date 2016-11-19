<?php

namespace app\controllers;

use app\utils\HttpRequest;
use app\utils\InscriptionWrapper;
use app\utils\Util;
use app\views\ActivityView;
use app\views\EventView;
use app\views\DefaultView;
use app\views\ParticipantView;
use app\models\Activity;
use app\models\Event;
use app\models\Participant;
use app\utils\Authentification;


class ActivityController extends AbstractController {

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
                //verification de la date si elle est valide
                $event = Event::find($this->request->get['id']);
                $datetimeEventStart = new \DateTime($event->startDate);
                $datetimeEventEnd = new \DateTime($event->endDate);
                $datetimeActivity = new \DateTime($this->request->post['startDate']);
                $datetimeEventStart = $datetimeEventStart->format('Ymd');
                $datetimeEventEnd = $datetimeEventEnd->format('Ymd');
                $datetimeActivity = $datetimeActivity->format('Ymd');
                
                if($datetimeActivity >= $datetimeEventStart && $datetimeActivity <= $datetimeEventEnd)
                {
                    $activity = new Activity();
                    $activity->name = $this->request->post['name'];
                    $activity->description =  $this->request->post['description'];
                    $activity->price = $this->request->post['price'];

                    $date = new \DateTime($this->request->post['startDate']);
                    $date->setTime($this->request->post['startDateH'], $this->request->post['startDateM']);
                    $activity->date =  $date;

                    $activity->id_event =  $this->request->get['id'];
                    $activity->save();
                    $this->redirectTo("../detail/?id=".$activity->id."&event_id=".$activity->id_event);
                }

                $_SESSION['dateValide'] = false;
            }
            $view = new ActivityView($this->request);
            return $view->render('add');
        }
        header("location: ../../signin/");
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
                $activity->price = $this->request->post['price'];

                $activity->save();

                header("location: ../detail/?id=".$activity->id."&event_id=".$activity->id_event);
            }

            $view = new ActivityView($activity);
            return $view->render('edit');
        }

        header("location: ../../signin/");
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
        $view = new ParticipantView('Paiement validé');
        return $view->render('paiement');
    }

    public function validatePaiement()
    {
        $parti = [];
        $result = [];
        foreach ($_SESSION['recap'] as $value) {
            $activity = Activity::find($value->activity_id);
            $parts =  $activity->getParticipants();
            $parts->attach(Participant::find($value->participant_id));
            $part = $activity->getParticipants()->where('id_participant','=',$value->participant_id)->first();
            $part->pivot->participant_number = Util::generateParticipantNumber();
            $parti[] = $value->participant_id;
            $part->pivot->save();
        }

        foreach ($parti as $value) {
            $result[] = Participant::find($value);
        }

        $view = new ActivityView($result);
        return $view->render('validatePaiement');
    }

    public function register()
    {
        $participant = null;
        if($this->request->post)
        {
            $iw = new InscriptionWrapper();
            $participant = Participant::where('mail','=', $this->request->post['mail'])->first();

            //Verifier si le participant existe dans la BD
            if(!$participant)
            {
                if(Util::isDateValid($this->request->post['birthDate']))
                {
                    $participant = new Participant();
                    $participant->mail = $this->request->post['mail'];
                    $dateNaissance = new \Datetime($this->request->post['birthDate']);
                    $participant->birthDate = $dateNaissance;
                    $participant->firstName = $this->request->post['firstName'];
                    $participant->lastName = $this->request->post['lastName'];
                    $participant->save();
                }
                $_SESSION['dateNaiss'] = false;
                header('location:'.$this->request->script_name.'/activity/register/?id='.$this->request->get['id']);
            }
            $activity = Activity::find($this->request->get['id']);
            $iw->participant_id = $participant->id;
            $iw->participant_firstname = $participant->firstName;
            $iw->participant_lastname = $participant->lastName;
            $iw->activity_id = $activity->id;
            $iw->activity_name = $activity->name;
            $iw->activity_tarif = $activity->price;
            $iw->activity_date = $activity->date;
            $iw->event_id = $activity->id_event;
            array_push($_SESSION['recap'], $iw);
            $this->redirectTo($this->request->script_name.'/recapitulatif/');
        }
        $activity = Activity::find($this->request->get['id']);
        $view = new ActivityView($activity);
        return $view->render('register');
    }

    public function participants()
    {
        $activity = Activity::find($this->request->get['id']);
        $view = new ParticipantView(['event_id'=>$activity->id_event,'activity_id'=>$activity->id, 'activity_name'=>$activity->name,'participants'=>$activity->getParticipants]);
        return $view->render('participants');
    }

    public function recap(){
        if(isset($_GET['idPar']) && isset($_GET['idact']))
        {
            foreach ($_SESSION['recap'] as $key => $inscription) {
                    if($inscription->participant_id == $_GET['idPar'] && $inscription->activity_id == $_GET['idact'])
                    {
                        unset($_SESSION['recap'][$key]);
                    }
            }
        }
        $view = new ParticipantView(null);
        $view->render('recap');
    }


    public function export(){
        $id = $this->request->get['id'];
        if(!empty($id)){
            $activity = Activity::find($id);
           $participants = $activity->getParticipants()->get();
            $fp = fopen('php://memory', 'w');
            fputcsv($fp, ['Nom', 'Nº Participant','Date de Naissance', 'E-Mail']);
            foreach ($participants as $participant){
                fputcsv($fp, [$participant->lastName, $participant->getParticipantNumber(), $participant->birthDate, $participant->mail]);
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
        $av = new ActivityView(Activity::find($id));
        $av->render('publish');
    }

    public function importResult(){
        $id = $this->request->post['id'];
        if($_FILES['fichier']['error']>0){
            $_SESSION['message_form'] = 'Un erreur est arrivé';
            return;
        }
        $csvFile = $_FILES['fichier']['tmp_name'];
        $csvAsArray = array_map('str_getcsv',file($csvFile));
        $activity = Activity::find($id);
        $totalSaved = 0;
        foreach ($csvAsArray as $row){
            // row[0]= participant_number, row[1] = mail, row[2] = score, row[3] = ranking
            $participant = $activity->getParticipants()->where('participant_number','=',$row[0])->where('mail','=',$row[1])->first();
            if($participant){
                $participant->pivot->score = $row[2];
                $participant->pivot->ranking = $row[3];
                if($participant->pivot->save()){
                    $event = $activity->getEvent;
                    $event->status = EVENT_STATUS_PUBLISHED;
                    $event->save();
                    $totalSaved++;
                }
            }
        }
        if($totalSaved>0){
            $av = new ActivityView($activity);
            $av->render('results');
        }else{
            $av = new ActivityView($activity);
            $av->render('publish');
            //$_SESSION['message_form'] = 'Un erreur est arrivé, vérifiez que l\'évenement a participants inscrits';
        }
    }

    public function results(){
        $id = $this->request->get['id'];
        $activity = Activity::find($id);
        $participants = $activity->getParticipants()->orderBy('ranking')->get();
        $av = new ParticipantView(['activity_id'=>$activity->id, 'activity_name'=>$activity->name, 'participants'=>$participants]);
        $av->render('results');
    }

    public function searchParticipants(){
        $searchText = filter_var(trim($this->request->post['searchQuery']),FILTER_SANITIZE_STRING);
        $searchText = empty($searchText) ? '%' : "%$searchText%";
        $activity = Activity::find($this->request->post['id']);
        $participants = $activity->getParticipants()->where('firstName', 'like',$searchText)->
            orWhere('lastName','like',$searchText)
            ->orWhere('participant_number','like',$searchText)
            ->orWhere('mail','like',$searchText)
            ->orderBy('ranking')
            ->get();
        $view = new ParticipantView(['activity_id'=>$activity->id, 'activity_name'=>$activity->name,'participants'=>$participants]);
        $view->render('results');
    }

}
