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
    public static function areDatesValid($dates){
        foreach ($dates as $date){
            $dt = DateTime::createFromFormat("d-m-Y", $date);
            if(!($dt !== false && !array_sum($dt->getLastErrors()))){
                return false;
            }
        }
        return true;
    }

    public static function generateParticipantNumber(){
        $numPart = rand(0,999999);
        return str_pad("".$numPart,6, "0",STR_PAD_LEFT);
    }
}