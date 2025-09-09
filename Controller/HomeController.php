<?php
require_once __DIR__ . '/../Config.php';
require_once __DIR__ . '/../Utils/View.php';

class HomeController {
    public function Index() {
        $data = [
            'page_title' => 'Home',
            'cssFile' => 'Home.css',
        ];
        render(__DIR__ . '/../Views/Home.php', $data);
    }
}