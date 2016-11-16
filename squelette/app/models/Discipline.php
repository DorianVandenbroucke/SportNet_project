<?php

/**
 * Created by PhpStorm.
 * User: marco
 * Date: 15/11/16
 * Time: 14:55
 */
namespace app\models;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    protected $table = 'discipline';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];
    public $timestamps = false;

    public function getEvents(){
        return $this->hasMany('\app\models\Event', 'id_discipline');
    }
}