<?php
class Router {
    public function Route() {
        $url = isset($_GET['url']) ? explode('/', trim($_GET['url'], '/')) : ['Home'];
        $controllerName = ucfirst(array_shift($url)) . 'Controller';
        $action = !empty($url) ? array_shift($url) : 'Index';

        $controllerFile = __DIR__ . '/../Controller/' . $controllerName . '.php';
        if (!file_exists($controllerFile)) {
            die("Controller $controllerName not found");
        }

        require_once $controllerFile;
        $controller = new $controllerName();
        if (!method_exists($controller, $action)) {
            die("Action $action not found in $controllerName");
        }

        if (!empty($url)) {
            call_user_func_array([$controller, $action], $url);
        } else {
            $controller->$action();
        }
    }
}