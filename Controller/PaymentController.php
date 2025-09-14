<?php
require_once __DIR__ . '/../Config.php';
require_once __DIR__ . '/../Model/Payment/PaymentGateway.php';
require_once __DIR__ . '/../Model/Payment/StripeAdapter.php';
require_once __DIR__ . '/../Model/Payment/PayPalAdapter.php';
require_once __DIR__ . '/../Utils/SecurePractices/PaymentUtils.php';
require_once __DIR__ . '/../Utils/View.php';

secure_session_start();

class PaymentController {
    public function Index() {
        if (!isset($_SESSION['booking'])) {
            header('Location: ' . BASE_URL . 'index.php?url=Reservation');
            exit;
        }
        $data = [
            'page_title' => 'Payment',
            'booking' => $_SESSION['booking']
        ];
        render(__DIR__ . '/../Views/Payment/Payment.php', $data);
    }

    // Handle POST actions
    public function Process() {
        $action = $_POST['action'] ?? '';
        $allowedActions = ["checkout", "refund"];

        if (!in_array($action, $allowedActions)) {
            log_error("Unauthorized action attempted: " . htmlspecialchars($action));
            $data = [
                'page_title' => 'Payment',
                'error' => 'Invalid request.'
            ];
            render(__DIR__ . '/../Views/Payment/Payment.php', $data);
            return;
        }

        switch ($action) {
            case "checkout":
                $amount = $_POST['amount'] ?? null;
                $gateway = $_POST['gateway'] ?? 'stripe';

                if (!validate_amount($amount) || 
                    !validate_card($_POST['card']) || 
                    !validate_expiry($_POST['expiry']) || 
                    !validate_cvv($_POST['cvv'])) {
                    log_error("Invalid payment input.");
                    $data = [
                        'page_title' => 'Checkout',
                        'error' => 'Payment failed. Please check your details.'
                    ];
                    render(__DIR__ . '/../Views/Payment/Checkout.php', $data);
                    return;
                }

                $paymentProcessor = ($gateway === "paypal") ? new PayPalAdapter() : new StripeAdapter();

                try {
                    $paymentProcessor->pay($amount, [
                        "card" => clean_input($_POST['card']),
                        "expiry" => clean_input($_POST['expiry']),
                        "cvv" => clean_input($_POST['cvv'])
                    ]);

                    $_SESSION['invoice'] = [
                        "invoice_id" => uniqid("INV"),
                        "reservation_id" => $_SESSION['booking']['id'] ?? "Unknown",
                        "amount" => $amount,
                        "gateway" => $gateway,
                        "date" => date("Y-m-d H:i:s")
                    ];

                    header('Location: ' . BASE_URL . 'index.php?url=Invoice');
                    exit;
                } catch (Exception $e) {
                    log_error("Payment failed: " . $e->getMessage());
                    $data = [
                        'page_title' => 'Checkout',
                        'error' => 'Payment failed. Please try again later.'
                    ];
                    render(__DIR__ . '/../Views/Payment/Checkout.php', $data);
                }
                break;

            case "refund":
                $invoiceId = clean_input($_POST['invoice_id']);
                $data = [
                    'page_title' => 'Refund Request',
                    'message' => "Refund request for Invoice ID: " . htmlspecialchars($invoiceId) . " processed."
                ];
                render(__DIR__ . '/../Views/Payment/Refund.php', $data);
                break;
        }
    }
}

// Handle routing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    (new PaymentController())->Process();
} else {
    (new PaymentController())->Index();
}
