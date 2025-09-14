<?php
require_once __DIR__ . '/../Config.php';
require_once __DIR__ . '/../Utils/View.php';
require_once __DIR__ . '/../DBConnect.php';
require_once __DIR__ . '/../Model/Entity/RoomEntity.php';

class RoomsController {
    public function Index() {
        $data = [
            'page_title' => 'Rooms',
            'cssFile'    => 'Room.css',
            'jsFile'     => 'Room.js',
        ];
        render(__DIR__ . '/../Views/Room/Rooms.php', $data);
    }

    public function apiRooms() {
        header('Content-Type: application/json');
        try {
            $rooms = Room::getAvailableRooms();

            $roomsData = array_map(function($room) {
                return [
                    'room_id' => $room->room_id,
                    'room_name' => $room->room_name,
                    'room_type' => $room->room_type,
                    'room_picture' => $room->room_picture,
                    'max_occupancy' => $room->max_occupancy,
                    'bed_type' => $room->bed_type,
                    'size' => $room->size,
                    'price' => $room->price,
                    'status' => $room->status,
                    'description' => $room->description
                ];
            }, $rooms);

            echo json_encode([
                'success' => true,
                'data'    => $roomsData
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'DB error: ' . $e->getMessage()
            ]);
        }
    }
}