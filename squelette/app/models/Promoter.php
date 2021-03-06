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
    protected $table = 'promoter';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'mail','login','password'];
    public $timestamps = false;

    public function getEvents(){
        return $this->hasMany('\app\models\Event', 'id_promoter');
    }

    static public function findByName($login){
        return Promoter::where('login', '=', $login)->first();
    }


}
