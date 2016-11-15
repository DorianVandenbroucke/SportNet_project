<?php

namespace app\models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model{
    protected $table = 'event';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function getActivities(){
        return $this->hasMany('app\models\Activity');
    }
}