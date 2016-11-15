<?php

namespace app\models;

class Event extends \Illuminate\Database\Eloquent\Model{
    protected $table = 'event';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function getActivities(){
        return $this->hasMany('app\models\Activity');
    }
}