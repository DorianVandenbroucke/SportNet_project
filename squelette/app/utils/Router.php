<?php

namespace app\utils;

class Router extends AbstractRouter{


    public function addRoute($url, $ctrl, $mth){
        self::$routes[$url] = [$ctrl, $mth];
    }

    public function dispatch(HttpRequest $http_request){
        if (!is_null($http_request->path_info) && isset(self::$routes[$http_request->path_info][0])){
            $controller = self::$routes[$http_request->path_info][0];
            $action = self::$routes[$http_request->path_info][1];
            $ctrl = new $controller($http_request);
            $ctrl->$action();

        }else {
            $controller = self::$routes["default"][0];
            $action = self::$routes["default"][1];
            $ctrl = new $controller($http_request);
            $ctrl->$action();

        }
    }

}
