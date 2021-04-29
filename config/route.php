<?php


class Router {

    public static function buildRoute() {

        $controllerName = "IndexController";
        $modelName = "IndexModel";
        $actionName = "index";

        $route = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        $i = count($route) -1;

        while($i>0) {
            if ($route[$i] != '') {
                if (is_file(CONTROLLER_PATH . ucfirst($route[$i] . 'Controller.php')) || !empty($_GET)) {
                    $controllerName = ucfirst($route[$i]) . 'Controller';
                    $modelName = ucfirst($route[$i]) . 'Model';
                    break;
                } else {
                    $actionName = $route[$i];
                }
            }
            $i--;
        }
       

        require_once(CONTROLLER_PATH . $controllerName . '.php');
        require_once(MODEL_PATH . $modelName . '.php');


        $controller = new $controllerName();
        $controller->$actionName();

    }

    public function errorPage() {
        return true;
    }
}
