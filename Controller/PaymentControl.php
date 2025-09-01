<?php
date_default_timezone_set('Asia/Singapore');
require_once "../Model/Payment/PaymentGateway.php";
require_once "../Model/Payment/StripeAdapter.php";
require_once "../Model/Payment/PayPalAdapter.php";
require_once "../Ultis/SecurePractices/SecurityUltis.php";

secure_session_start();

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

            echo $result;
        } catch (Exception $e) {
            log_error("Payment failed: " . $e->getMessage());
            echo "Payment failed. Please try again later.";
        }
        break;

    case "refund":
        $invoiceId = clean_input($_POST['invoice_id']);
        echo "Refund request for Invoice ID: " . $invoiceId . " processed.";
        break;

    default:
        echo "Invalid action.";
}
