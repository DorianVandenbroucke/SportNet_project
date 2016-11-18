<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 18/11/16
 * Time: 14:45
 */

namespace app\utils;


class InscriptionWrapper
{
    private $participant_id;
    private $participant_firstname;
    private $participant_lastname;
    private $activity_id;
    private $activity_name;
    private $activity_date;
    private $activity_tarif;
    private $event_id;

    public function __construct()
    {

    }

    public function __get($attr_name) {
        if (property_exists( __CLASS__, $attr_name))
            return $this->$attr_name;
        $emess = __CLASS__ . ": unknown member $attr_name (__get)";
        throw new \Exception($emess);
    }

    public function __set($attr_name, $attr_val) {
        if (property_exists( __CLASS__, $attr_name))
            $this->$attr_name=$attr_val;
        else{
            $emess = __CLASS__ . ": unknown member $attr_name (__set)";
            throw new \Exception($emess);
        }
    }

    public function __toString(){
        $prop = get_object_vars ($this);
        $str="";
        foreach ($prop as $name => $val){
            if( !is_array($val) )
                $str .= "$name : $val <br> ";
            else
                $str .= "$name : ". print_r($val, TRUE)."<br>";
        }
        return $str;
    }

    public function printData(){
        return $this->__toString();
    }
}