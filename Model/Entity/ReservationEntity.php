<?php
require_once __DIR__ . '/../../DBConnect.php';
class ReservationEntity {
    private $reservationId;
    private $userId;
    private $roomId;
    private $checkInDate;
    private $checkOutDate;
    private $adult;
    private $children;
    private $reservationType;
    private $totalAmount;
    public  $status;
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance();
    }

    public function getUserId(){return $this->userId;}
    public function getReservationId(){return $this->reservationId;}
    public function getRoomId(){return $this->roomId;}
    public function getCheckInDate(){return $this->checkInDate;}
    public function getCheckOutDate(){return $this->checkOutDate;}
    public function getAdult(){return $this->adult;}
    public function getChildren(){return $this->children;}
    public function getReservationType(){return $this->reservationType;}
    public function getStatus(){return $this->status;}
    public function getTotalAmount(){return $this->totalAmount;}

    private function getTypeFromGuests($adults, $children) {
        if ($adults == 1 && $children == 0) return "Single";
        if ($adults > 1 && $children == 0) return "Group";
        return "Family";
    }

    public function create($userId, $roomId, $checkIn, $checkOut, $adult, $children, $totalAmount, $status) {
        $this->reservationType = $this->getTypeFromGuests($adult, $children);
        $stmt = $this->conn->prepare("
            INSERT INTO reservations 
            (user_id, room_id, reservationType, adult, children, check_in, check_out, total_amount, status, created_at)
            VALUES (:user_id, :room_id, :reservationType, :adult, :children, :check_in, :check_out, :total_amount, :status, NOW())
        ");

        $stmt->execute([
            ':user_id' => $userId,
            ':room_id' => $roomId,
            ':reservationType' => $this->reservationType,
            ':adult' => $adult,
            ':children' => $children,
            ':check_in' => $checkIn,
            ':check_out' => $checkOut,
            ':total_amount' => $totalAmount,
            ':status' => $status
        ]);
        return $this->conn->lastInsertId();
    }

    public function selectReservation($reservationId) {
        $stmt = $this->conn->prepare("
            SELECT r.reservation_id AS reservationId, r.user_id AS userId, u.username AS userName,
                   r.room_id AS roomId, rm.room_name AS roomName, rm.room_type AS roomType,
                   r.check_in AS checkIn, r.check_out AS checkOut, r.adults, r.children,
                   r.total_amount AS totalAmount, r.status, r.created_at AS createdAt
            FROM reservations r
            JOIN users u ON r.user_id = u.user_id
            JOIN rooms rm ON r.room_id = rm.room_id
            WHERE r.reservation_id = :reservation_id
        ");
        $stmt->execute([':reservation_id' => $reservationId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function __toString()
    {
        return __CLASS__ . "User ID: {$this->userId}, Reservation ID: {$this->reservationId}, Check In Date: {$this->checkInDate}, Check Out Date: {$this->checkOutDate}, Adult: {$this->adult}, Children: {$this->children}, Total Amount: {$this->totalAmount}, Total status: {$this->status}";
    }
}