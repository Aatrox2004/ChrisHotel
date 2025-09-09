<?php
require_once __DIR__ . '/../Config.php';
require_once __DIR__ . '/../Utils/View.php';
require_once __DIR__ . '/../Model/Entity/ReservationEntity.php';
require_once __DIR__ . '/../Model/Strategies/SingleReservation.php';
require_once __DIR__ . '/../Model/Strategies/CoupleReservation.php';
require_once __DIR__ . '/../Model/Strategies/GroupReservation.php';

class ReservationController {
    public function Index() {
        $data = [
            'page_title' => 'Reservation',
            'cssFile' => 'ReservationForm.css',
            'jsFile' => 'ReservationForm.js'
        ];
        render(__DIR__ . '/../Views/Reservation/ReservationForm.php', $data);
    }

    public function Process() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Method Not Allowed';
            exit;
        }

        function sanitizeInput($data) {
            return htmlspecialchars(stripslashes(trim($data)));
        }

        $name        = sanitizeInput($_POST['name'] ?? '');
        $checkinStr  = sanitizeInput($_POST['checkin'] ?? '');
        $checkoutStr = sanitizeInput($_POST['checkout'] ?? '');
        $roomType    = sanitizeInput($_POST['room'] ?? '');
        $guests      = intval($_POST['guests'] ?? 1);

        $roomPriceRaw       = $_POST['room_price'] ?? '';
        $roomStatus         = $_POST['room_status'] ?? '';
        $roomDescription    = $_POST['room_description'] ?? '';

        if ($name === '' || $checkinStr === '' || $checkoutStr === '' || $roomType === '') {
            http_response_code(400);
            echo 'Missing required reservation data';
            exit;
        }

        try {
            $checkin  = new DateTime($checkinStr);
            $checkout = new DateTime($checkoutStr);
        } catch (Exception $e) {
            http_response_code(400);
            echo 'Invalid dates';
            exit;
        }

        $interval = $checkin->diff($checkout);
        $nights = $interval->days;
        if ($nights <= 0) {
            http_response_code(400);
            echo 'Check-out date must be after check-in date';
            exit;
        }

        if ($guests === 1) {
            $strategy = new SingleReservation();
        } elseif ($guests === 2) {
            $strategy = new CoupleReservation();
        } else {
            $strategy = new GroupReservation();
        }

        $totalPrice = $strategy->calculatePrice($nights, $guests);

        try {
            require_once __DIR__ . '/../DBConnect.php';
            $db = Database::getInstance();

            $stmt = $db->prepare('
                INSERT INTO reservations
                (guest_name, checkin, checkout, room_type, room_price, room_status, room_description, guests, nights, total_price, created_at)
                VALUES
                (:guest_name, :checkin, :checkout, :room_type, :room_price, :room_status, :room_description, :guests, :nights, :total_price, NOW())
            ');

            $stmt->execute([
                ':guest_name'      => $name,
                ':checkin'         => $checkin->format('Y-m-d'),
                ':checkout'        => $checkout->format('Y-m-d'),
                ':room_type'       => $roomType,
                ':room_price'      => floatval(str_replace(',', '.', $roomPriceRaw)), // raw room price if needed
                ':room_status'     => $roomStatus,
                ':room_description'=> $roomDescription,
                ':guests'          => $guests,
                ':nights'          => $nights,
                ':total_price'     => $totalPrice
            ]);

            $reservationId = $db->lastInsertId();

            session_start();
            $_SESSION['booking'] = [
                'reservation_id' => $reservationId,
                'name'           => $name,
                'checkin'        => $checkinStr,
                'checkout'       => $checkoutStr,
                'room'           => $roomType,
                'guests'         => $guests,
                'nights'         => $nights,
                'total'          => $totalPrice
            ];
            $_SESSION['total'] = round($totalPrice, 2);

            header('Location: ' . BASE_URL . 'index.php?url=Payment');
            exit;
        } catch (Exception $e) {
            error_log('Reservation save error: ' . $e->getMessage());
            http_response_code(500);
            echo 'Server error while saving reservation';
            exit;
        }
    }
}
