<?php
require_once __DIR__ . '/../Config.php';
require_once __DIR__ . '/../Utils/View.php';

class UserProfileController {
    public function Index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'Views/User/Login.php');
            exit;
        }
        $data = [
            'page_title' => 'User Profile',
            'user' => [
                'name' => $_SESSION['user_id'], // Placeholder
                'email' => $_SESSION['user_id'] . '@example.com', // Placeholder
                'membership' => 'Standard' // Placeholder
            ],
            'booking' => $_SESSION['booking'] ?? ['total' => 0, 'checkin' => '', 'checkout' => '']
        ];
        render(__DIR__ . '/../Views/User/UserProfile.php', $data);
    }

    public function apiUser($userId) {
        header('Content-Type: application/json');
        try {
            $user = UserEntity::getUser($userId);
            if (!$user) {
                echo json_encode([
                    'success' => false,
                    'message' => 'User not found'
                ]);
                return;
            }

            echo json_encode([
                'success' => true,
                'data' => $user
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'DB error: ' . $e->getMessage()
            ]);
        }
    }

    public function apiAdmins() {
        header('Content-Type: application/json');
        try {
            $admins = UserEntity::getAdmin();
            echo json_encode([
                'success' => true,
                'data' => $admins
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'DB error: ' . $e->getMessage()
            ]);
        }
    }
}

// Handle routing
(new UserProfileController())->Index();