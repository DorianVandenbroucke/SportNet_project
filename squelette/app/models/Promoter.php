<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 15/11/16
 * Time: 15:02
 */

namespace app\models;


use Illuminate\Database\Eloquent\Model;

class Promoter extends Model
{
    protected $table = 'discipline';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'mail','login','password'];

    public function getEvents(){
        return $this->hasMany('\app\models\Event', 'id_promoter');
    }
}