<?php

namespace app\utils;

abstract class AbstractRouter {

    public static $routes = array ();

    abstract public function addRoute($url, $ctrl, $mth);

    abstract public function dispatch(HttpRequest $http_request);

}
