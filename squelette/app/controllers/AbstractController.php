<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 18/11/16
 * Time: 15:53
 */

namespace app\controllers;


abstract class AbstractController
{
    protected function redirectTo($route){
        header("location: $route");
    }
}