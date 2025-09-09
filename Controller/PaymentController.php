<?php
require_once __DIR__ . '/../Config.php'; // Ensure BASE_URL is defined
date_default_timezone_set('Asia/Singapore');
require_once __DIR__ . '/../Model/Payment/PaymentGateway.php';
require_once __DIR__ . '/../Model/Payment/StripeAdapter.php';
require_once __DIR__ . '/../Model/Payment/PayPalAdapter.php';
require_once __DIR__ . '/../Utils/SecurePractices/SecurityUtils.php';
require_once __DIR__ . '/../Utils/View.php';

secure_session_start();

class PaymentController {
    public function Index() {
        // Default view for payment
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

    public function Checkout() {
        if (!isset($_SESSION['booking'])) {
            header('Location: ' . BASE_URL . 'index.php?url=Login');
            exit;
        }
        $data = [
            'page_title' => 'Checkout',
            'booking' => $_SESSION['booking']
        ];
        render(__DIR__ . '/../Views/Payment/Checkout.php', $data);
    }

    public function Invoice() {
        if (!isset($_SESSION['invoice'])) {
            header('Location: ' . BASE_URL . 'index.php?url=Checkout');
            exit;
        }
        $data = [
            'page_title' => 'Invoice',
            'invoice' => $_SESSION['invoice']
        ];
        render(__DIR__ . '/../Views/Payment/Invoice.php', $data);
    }

    public function Refund() {
        if (!isset($_SESSION['invoice'])) {
            header('Location: ' . BASE_URL . 'index.php?url=Invoice');
            exit;
        }
        $data = [
            'page_title' => 'Refund Request',
            'invoice' => $_SESSION['invoice']
        ];
        render(__DIR__ . '/../Views/Payment/Refund.php', $data);
    }

    // Handle POST actions
    public function Process() {
        $action = $_POST['action'] ?? '';
        switch ($action) {
            case "checkout":
                $amount = $_POST['amount'] ?? null;
                $gateway = $_POST['gateway'] ?? 'stripe';

                if (!validate_amount($amount) || 
                    !validate_card($_POST['card']) || 
                    !validate_expiry($_POST['expiry']) || 
                    !validate_cvv($_POST['cvv'])) {
                    die("Invalid payment details.");
                }

                $paymentProcessor = ($gateway === "paypal") ? new PayPalAdapter() : new StripeAdapter();

                try {
                    $result = $paymentProcessor->pay($amount, [
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

                    header('Location: ' . BASE_URL . 'index.php?url=Payment/Invoice');
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
                    'message' => "Refund request for Invoice ID: " . $invoiceId . " processed."
                ];
                render(__DIR__ . '/../Views/Payment/Refund.php', $data);
                break;

            default:
                $data = [
                    'page_title' => 'Payment',
                    'error' => 'Invalid action.'
                ];
                render(__DIR__ . '/../Views/Payment/Payment.php', $data);
        }
    }
}

// Handle routing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    (new PaymentController())->Process();
} elseif (isset($_GET['action'])) {
    $action = $_GET['action'];
    $controller = new PaymentController();
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        $controller->Index();
    }
} else {
    (new PaymentController())->Index();
}