<?php
class ReservationEntity {
    private $reservationId;
    private $custName;
    private $roomId;
    private $checkInDate;
    private $checkOutDate;
    private $adults;
    private $children;
    private $reservationType;
    private $price;
    private $roomPrice; // Added to store room's base price

    public function __construct($custName, $checkInDate, $checkOutDate, $adults, $children, $roomPrice, $price) {
        $this->custName = $custName;
        $this->reservationId = uniqid('RES-');
        $this->checkInDate = $checkInDate;
        $this->checkOutDate = $checkOutDate;
        $this->adults = $adults;
        $this->children = $children;
        $this->reservationType = $this->getTypeFromGuests($adults, $children);
        $this->roomPrice = $roomPrice;
        $this->price = $price;
    }

    public function getcustName(){return $this->custName;}
    public function getReservationId(){return $this->reservationId;}
    public function getCheckInDate(){return $this->checkInDate;}
    public function getCheckOutDate(){return $this->checkOutDate;}
    public function getAdults(){return $this->adults;}
    public function getChildren(){return $this->children;}
    public function getReservationType(){return $this->reservationType;}
    public function getRoomPrice(){return $this->roomPrice;}
    public function getPrice(){return $this->price;}
    
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    private function getTypeFromGuests($adults, $children) {
        if ($adults == 1 && $children == 0) return "Single";
        if ($adults > 1 && $children == 0) return "Group";
        return "Family";
    }

    public static function create($userId, $roomId, $checkIn, $checkOut, $adults, $children, $roomPrice) {
        global $conn;
        $stmt = $conn->prepare("
            INSERT INTO reservations (user_id, room_id, check_in, check_out, adults, children, room_price, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')
        ");
        $stmt->bind_param("iissiid", $userId, $roomId, $checkIn, $checkOut, $adults, $children, $roomPrice);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        }
        return false;
    }

    public function __toString()
    {
        return __CLASS__ . "Customer Name: {$this->custName}, Reservation ID: {$this->reservationId}, Check In Date: {$this->checkInDate}, Check Out Date: {$this->checkOutDate}, Adults: {$this->adults}, Children: {$this->children}, Room Price: {$this->roomPrice}, Total Price: {$this->price}";
    }

    public static function getAvailableRoomsViaAPI($baseUrl) {
        $apiUrl = $baseUrl . 'index.php?url=Rooms/apiRooms';
        $context = stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'timeout' => 10
            ]
        ]);
        $response = @file_get_contents($apiUrl, false, $context);
        if ($response === false) {
            return [];
        }
        $data = json_decode($response, true);
        return $data['success'] ? $data['data'] : [];
    }
}