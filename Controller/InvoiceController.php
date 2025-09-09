<?php
require_once __DIR__ . '/../Config.php';
require_once __DIR__ . '/../Utils/View.php';

class InvoiceController {
    public function Index() {
        if (!isset($_SESSION['invoice'])) {
            header('Location: ' . BASE_URL . 'Views/Payment/Checkout.php');
            exit;
        }
        $data = [
            'page_title' => 'Invoice',
            'invoice' => $_SESSION['invoice']
        ];
        render(__DIR__ . '/../Views/Payment/Invoice.php', $data);
    }
}

// Handle routing
(new InvoiceController())->Index();