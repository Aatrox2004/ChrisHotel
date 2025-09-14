<?php
require_once __DIR__ . '/../Config.php';
require_once __DIR__ . '/../Utils/View.php';
require_once __DIR__ . '/../DBConnect.php';
require_once __DIR__ . '/../Model/Entity/ReservationEntity.php';
require_once __DIR__ . '/../Model/Strategies/ReservationStrategyFactory.php';
require_once __DIR__ . '/RoomsController.php';
require_once __DIR__ . '/LoginController.php';

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

        if (!$name || !$checkinStr || !$checkoutStr || $roomPrice <= 0) {
            $this->respondError("Missing or invalid reservation data", 400);
        }

        $userId = $this->getUserIdFromLoginController($name);
        if (!$userId) {
            $this->respondError("User not found", 404);
        }

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

        // Determine strategy Design Pattern
        $strategy = ReservationStrategyFactory::create($adults, $children);
        $totalPrice = $strategy->calculatePrice($nights, $adults, $children, $roomPrice);

        $reservationEntity = new ReservationEntity();
        $reservationId = $reservationEntity->create(
            $userId,
            $roomId,
            $checkin->format('Y-m-d'),
            $checkout->format('Y-m-d'),
            $adults,
            $children,
            $totalPrice,
            'Pending'
        );

        $_SESSION['booking'] = [
            'reservation_id' => $reservationId,
        ];

        header('Location: ' . BASE_URL . 'index.php?url=Payment&reservation_id=' . $reservationId);
        exit;
    }

    private function getUserIdFromLoginController($username) {
        $url = BASE_URL . "index.php?url=Login/apiGetUserByName&username=" . urlencode($username);

        $response = @file_get_contents($url); // suppress warning
        if (!$response) return null;

        $data = json_decode($response, true);
        if (!is_array($data) || !isset($data['success']) || !$data['success']) {
            return null;
        }

        return $data['data']['user_id'] ?? null;
    }

    public function apiReservation($reservationId = null) {
        header('Content-Type: application/json');

        try {
            if (!$reservationId) {
                $reservationId = $_POST['reservation_id'] ?? $_GET['reservation_id'] ?? null;
            }

            if (!$reservationId) {
                echo json_encode(['success' => false, 'message' => 'Reservation ID required']);
                exit;
            }

            $reservationEntity = new ReservationEntity();
            $reservation = $reservationEntity->selectReservation($reservationId);

            if (!$reservation) {
                echo json_encode(['success' => false, 'message' => 'Reservation not found']);
                exit;
            }

            echo json_encode([
                'success' => true,
                'data' => $reservation
            ]);

        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
        exit;
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