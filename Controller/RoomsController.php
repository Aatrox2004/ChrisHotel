<?php
require_once __DIR__ . '/../Config.php';
require_once __DIR__ . '/../Utils/View.php';

class RoomsController {
    public function Index() {
        $data = [
            'page_title' => 'Rooms'
        ];
        render(__DIR__ . '/../Views/Room/Rooms.php', $data);
    }
}