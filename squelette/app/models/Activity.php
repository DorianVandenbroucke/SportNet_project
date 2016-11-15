<?php

namespace app\models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model{

	protected $table = "activity";
	protected $primaryKey = "id";
	
	public function getEvent(){
		return $this->belongsTo('\app\models\Event', 'id_event');
	}

}