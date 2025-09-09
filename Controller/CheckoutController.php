<?php
require_once __DIR__ . '/../Config.php';
require_once __DIR__ . '/../Utils/View.php';

class CheckoutController {
    public function Index() {
        if (!isset($_SESSION['booking'])) {
            header('Location: ' . BASE_URL . 'Views/User/Login.php');
            exit;
        }
        $data = [
            'page_title' => 'Checkout',
            'booking' => $_SESSION['booking']
        ];
        render(__DIR__ . '/../Views/Payment/Checkout.php', $data);
    }
}

// Handle routing
(new CheckoutController())->Index();