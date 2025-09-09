<?php
require_once __DIR__ . '/../Config.php';
require_once __DIR__ . '/../DBConnect.php';

class RoomApiController
{
    // GET /index.php?url=RoomApi/GetRoom&room=Standard  OR &id=123
    public function GetRoom()
    {
        header('Content-Type: application/json; charset=utf-8');

        $roomParam = trim($_GET['room'] ?? '');
        $idParam   = trim($_GET['id'] ?? '');

        if ($roomParam === '' && $idParam === '') {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'missing room or id parameter']);
            return;
        }

        try {
            $db = Database::getInstance();

            if ($idParam !== '') {
                $stmt = $db->prepare('SELECT id, room_type AS type, price, description, status FROM rooms WHERE id = :id LIMIT 1');
                $stmt->execute([':id' => $idParam]);
            } else {
                $stmt = $db->prepare('SELECT id, room_type AS type, price, description, status FROM rooms WHERE room_type = :room_type LIMIT 1');
                $stmt->execute([':room_type' => $roomParam]);
            }

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                http_response_code(404);
                echo json_encode(['success' => false, 'error' => 'room not found']);
                return;
            }

            // Ensure numeric price formatting
            $row['price'] = isset($row['price']) ? (float)$row['price'] : 0.0;

            echo json_encode(['success' => true, 'room' => $row]);
            return;
        } catch (Exception $e) {
            error_log('RoomApiController error: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'server error']);
            return;
        }
    }
}

// allow direct call to this file (router may also dispatch)
if (php_sapi_name() !== 'cli') {
    // Basic dispatch: call GetRoom when ?action=GetRoom or when file requested directly
    $action = $_GET['action'] ?? $_GET['url'] ?? 'GetRoom';
    $ctrl = new RoomApiController();
    if (method_exists($ctrl, $action)) {
        $ctrl->{$action}();
    } else {
        // default
        $ctrl->GetRoom();
    }
}