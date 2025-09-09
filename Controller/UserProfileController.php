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
}

// Handle routing
(new UserProfileController())->Index();