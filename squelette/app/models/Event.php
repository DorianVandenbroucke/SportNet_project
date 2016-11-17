<?php

namespace app\models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model{
    protected $table = 'event';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function getActivities(){
        return $this->hasMany('app\models\Activity', 'id_event');
    }

    public function getPromoter(){
        return $this->belongsTo('app\models\Promoter', 'id_promoter');
    }

    public function getDiscipline(){
        return $this->belongsTo('app\models\Discipline', 'id_discipline');
    }

    public function isOpen(){
        return $this->status == EVENT_STATUS_OPEN;
    }

    public function isClosed(){
        return $this->status == EVENT_STATUS_CLOSED;
    }

    public function isCreated(){
        return $this->status == EVENT_STATUS_CREATED;
    }

    public function isValidated(){
        return $this->status == EVENT_STATUS_VALIDATED;
    }

    public function isPublished(){
        return $this->status == EVENT_STATUS_PUBLISHED;
    }
}