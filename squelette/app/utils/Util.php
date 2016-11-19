<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 17/11/16
 * Time: 10:26
 */

namespace app\utils;

use DateTime;

define('MYSQL_DATE_FORMAT', 'Y-m-d');
define('MYSQL_DATE_TIME_FORMAT', 'Y-m-d H:i:s');
define('STANDARD_DATE_FORMAT', 'd-m-Y');

class Util
{
    public static function strToDate($strDate, $format){
        $date = strtr($strDate, '/', '-');
        return date($format,strtotime($date));
    }

    public static function dateToStr($date, $format){
        $date = new \DateTime($date);
        return $date->format($format);
    }

    public static function isCurrentEventPromoter($event){
        return (isset($_SESSION['promoter']) && $event->getPromoter->id == $_SESSION['promoter']);
    }

    public static function isEventModifyable($event){
        return self::isCurrentEventPromoter($event) && $event->status != EVENT_STATUS_PUBLISHED;
    }

    /***
     * @param $dates array of dates
     * @return bool is all dates are valid
     */
    public static function isDateValid($date){
            $dt = DateTime::createFromFormat("d-m-Y", $date);
            return $dt !== false && !array_sum($dt->getLastErrors());
    }

    public static function isHourValid($hour){
        $hour = trim($hour);
        try{
            echo intval($hour);
            return strlen($hour)<=2 && intval($hour) >= 0 && intval($hour) <=23;
        }catch(\Exception $e){
            return false;
        }
    }

    public static function isMinuteValid($minute){
        $minute = trim($minute);
        try{
            return strlen($minute)<=2 && intval($minute) >= 0 && intval($minute) <= 59;
        }catch(\Exception $e){
            return false;
        }
    }

    public static function isEmailValid($email){
        return filter_var(filter_var($email, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
    }

    public static function generateParticipantNumber(){
        $numPart = rand(0,999999);
        return str_pad("".$numPart,6, "0",STR_PAD_LEFT);
    }

    public static function isFuture($time)
    {
        return (strtotime($time) > time());
    }
}