<?php

namespace app\models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model{

	protected $table = "activity";
	protected $primaryKey = "id";
	public $timestamps = false;
	
	public function getEvent(){
		return $this->belongsTo('\app\models\Event', 'id_event');
	}
	
	public function getParticipants(){
        return $this->belongsToMany('\app\models\Participant', 'participant_activity', 'id_activity', 'id_participant')->withPivot('ranking', 'score','participant_number');;
	}

}