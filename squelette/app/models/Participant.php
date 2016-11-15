<?php

namespace app\models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model {

    protected $table = 'Participant';
    protected $primaryKey = 'id';
    protected $fillable = [
        'mail','birthDate','firstName','lastName'
    ];

    public function getActivities(){
        return $this->belongsToMany('\app\models\Activity', 'Participant_Activity', 'id_participant', 'id_activity');
    }
}
