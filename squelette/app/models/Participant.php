<?php

namespace app\models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model {

    protected $table = 'participant';
    protected $primaryKey = 'id';
    protected $fillable = [
        'mail','birthDate','firstName','lastName'
    ];
    public $timestamps = false;

    public function getActivities(){
        return $this->belongsToMany('\app\models\Activity', 'participant_activity', 'id_participant', 'id_activity');
    }

    public function getParticipantNumber(){
        return $this->getActivities()->select()->where('id_participant','=',$this->id)->first()->participant_number;
    }
}
