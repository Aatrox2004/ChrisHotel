<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'Config.php';
require_once 'Utils/Router.php';

$router = new Router();
$router->route();