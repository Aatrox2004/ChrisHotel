<?php
require_once __DIR__ . '/../Config.php';
require_once __DIR__ . '/../Utils/View.php';

class RefundController {
    public function Index() {
        if (!isset($_SESSION['invoice'])) {
            header('Location: ' . BASE_URL . 'Views/Payment/Invoice.php');
            exit;
        }
        $data = [
            'page_title' => 'Refund Request',
            'invoice' => $_SESSION['invoice']
        ];
        render(__DIR__ . '/../Views/Payment/Refund.php', $data);
    }
}

// Handle routing
(new RefundController())->Index();