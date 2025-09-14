<?php
require_once __DIR__ . '/../Config.php';
require_once __DIR__ . '/../Utils/View.php';
require_once __DIR__ . '/../DBConnect.php';
require_once __DIR__ . '/../Model/Entity/ReservationEntity.php';
require_once __DIR__ . '/../Model/Strategies/ReservationStrategyFactory.php';
require_once __DIR__ . '/RoomsController.php';

class ReservationController {

    public function Index() {
        $data = [
            'page_title' => 'Reservation',
            'cssFile'    => 'ReservationForm.css',
            'jsFile'     => 'ReservationForm.js'
        ];

        if ($this->isApiRequest()) {
            $this->respondJSON(true, "Reservation API endpoint ready");
        }

        render(__DIR__ . '/../Views/Reservation/ReservationForm.php', $data);
    }

    public function Process() {
        $input = $this->getRequestData();
        $reservationId = $this->sanitize($input['reservationID' ?? '']);
        $name          = $this->sanitize($input['name'] ?? '');
        $roomId        = $this->sanitize($input['roomId']);
        $checkinStr    = $this->sanitize($input['checkin'] ?? '');
        $checkoutStr   = $this->sanitize($input['checkout'] ?? '');
        $adults        = intval($input['adults'] ?? 1);
        $children      = intval($input['children'] ?? 0);
        $roomPrice     = floatval($input['room_price'] ?? 0);

        try {
            $checkin  = new DateTime($checkinStr);
            $checkout = new DateTime($checkoutStr);
        } catch (Exception $e) {
            $this->respondError("Invalid check-in/check-out dates", 400);
        }

        $nights = $checkin->diff($checkout)->days;
        if ($nights <= 0) {
            $this->respondError("Check-out must be after check-in", 400);
        }

        $strategy = ReservationStrategyFactory::create($adults, $children);
        $totalPrice = $strategy->calculatePrice($nights, $adults, $children, $roomPrice);

        try {
            $db = Database::getInstance();
            $stmt = $db->prepare("
                INSERT INTO reservations
                (reservation_id, user_id, room_id, check_in, check_out, total_amount, status, created_at)
                VALUES
                (:reservation_id, :user_id, :room_id, :check_in, :check_out, :total_amount, :status, NOW())
            ");
            $stmt->execute([
                ':reservation_id'  => $reservationId,
                ':user_id'         => $name,
                ':room_id'         => $roomId,
                ':check_in'        => $checkin->format('Y-m-d'),
                ':check_out'       => $checkout->format('Y-m-d'),
                ':total_amount'    => $totalPrice,
                ':status'          => 'Pending',
            ]);

            $reservationId = $db->lastInsertId();

            session_start();
            $_SESSION['booking'] = [
                ':reservation_id'  => $reservationId,
                ':user_id'         => $name,
                ':room_id'         => $roomId,
                ':check_in'        => $checkin->format('Y-m-d'),
                ':check_out'       => $checkout->format('Y-m-d'),
                ':total_amount'    => $totalPrice,
                ':status'          => 'Pending',
            ];
            $_SESSION['total'] = round($totalPrice, 2);

            if ($this->isApiRequest()) {
                $this->respondJSON(true, "Reservation successful", $_SESSION['booking']);
            } else {
                header('Location: ' . BASE_URL . 'index.php?url=Payment');
                exit;
            }

        } catch (Exception $e) {
            error_log('Reservation save error: ' . $e->getMessage());
            $this->respondError("Server error while saving reservation", 500);
        }
    }

    public function apiRoomsFromReservation() {
        try {
            $roomCtrl = new RoomsController();
            ob_start();
            $roomCtrl->apiRooms();
            echo ob_get_clean();
        } catch (Exception $e) {
            $this->respondJSON(false, "Failed to fetch rooms: " . $e->getMessage());
        }
    }

    private function isApiRequest(): bool {
        return (isset($_GET['api']) && $_GET['api'] == 1) ||
               (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false);
    }

    private function getRequestData(): array {
        if ($this->isApiRequest()) {
            return json_decode(file_get_contents("php://input"), true) ?? [];
        }
        return $_POST;
    }

    private function sanitize($data): string {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    private function respondJSON(bool $success, string $message, $data = null) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'message' => $message,
            'data'    => $data
        ]);
        exit;
    }

    private function respondError(string $message, int $status = 400) {
        http_response_code($status);
        if ($this->isApiRequest()) {
            $this->respondJSON(false, $message);
        } else {
            echo $message;
        }
        exit;
    }
}