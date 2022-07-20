<?php
/**
 * Created by Kotyk Ihor
 * Date : 19.07.2022
 * Time : 18:47
 */

namespace components;

use app\Controllers\MainController;

class Route
{
    /**
     * @return string
     */
    private function getURI():string
    {
        $uri = $_SERVER['REQUEST_URI'];
        if (!empty($uri)) {
            return trim($uri, '/');
        }
    }


    public function run()
    {
        $uri = $this->getURI();
        require_once ROOT.'/config/route.php';
        if(array_key_exists($uri, $routes)){
            $segments = explode('/',$routes[$uri]);
            $actionName = 'action'.$segments[1];
            $controllerName = $segments[0].'Controller';
            $controllerFile = 'app\Controllers\\'. $controllerName;
            $controllerLoad = new $controllerFile();
            $controllerLoad->$actionName();
        } else {
            $action = new MainController();
            $action->actionError();
        }
    }
}