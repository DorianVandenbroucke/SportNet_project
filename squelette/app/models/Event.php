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
}