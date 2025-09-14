<?php
class Room {
    public $room_id;
    public $room_number;
    public $room_type;
    public $room_picture;
    public $max_occupancy;
    public $bed_type;
    public $size;
    public $price;
    public $status;
    public $description;

    public static function getAvailableRooms() {
        $db = Database::getInstance(); // Use PDO
        $stmt = $db->prepare("SELECT room_id, room_name, room_type, room_picture, max_occupancy, bed_type, size, price, status, description FROM rooms WHERE status = 'Available'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Room'); // Fetch as Room objects
    }
}