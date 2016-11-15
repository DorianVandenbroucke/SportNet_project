<?php

/**
 * Created by PhpStorm.
 * User: marco
 * Date: 15/11/16
 * Time: 15:36
 */
namespace app\controllers;

use app\utils\HttpRequest;

class EventController
{
    private $request = null;

    public function __construct(HttpRequest $httpRequest)
    {
        $this->request = $httpRequest;
    }

    public function addEvent(){

    }
}