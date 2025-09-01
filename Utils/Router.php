<?php
class Router {
    public function route() {
        $url = isset($_GET['url']) ? explode('/', trim($_GET['url'], '/')) : ['home'];
        $controllerName = ucfirst(array_shift($url)) . 'Controller';
        $action = !empty($url) ? array_shift($url) : 'index';

        $controllerFile = "controllers/$controllerName.php";
        if (!file_exists($controllerFile)) {
            die("Controller $controllerName not found");
        }

        require_once $controllerFile;
        $controller = new $controllerName();
        if (!method_exists($controller, $action)) {
            die("Action $action not found in $controllerName");
        }

        // If there are remaining parts in the URL, pass them as arguments to the controller action
        if (!empty($url)) {
            // Call the controller action with arguments
            call_user_func_array([$controller, $action], $url);
        } else {
            // Call the controller action without arguments
            $controller->$action();
        }
    }
}