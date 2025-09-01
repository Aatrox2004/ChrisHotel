<?php
require_once "PaymentGateway.php";

class PayPalAdapter implements PaymentGateway {
    public function pay($amount, $cardDetails) {
        return "PayPal: Payment of $" . htmlspecialchars($amount) . " processed successfully.";
    }
}
