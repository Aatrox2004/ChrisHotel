<?php
require_once "PaymentGateway.php";

class StripeAdapter implements PaymentGateway {
    public function pay($amount, $cardDetails) {
        return "Stripe: Payment of $" . htmlspecialchars($amount) . " processed successfully.";
    }
}
