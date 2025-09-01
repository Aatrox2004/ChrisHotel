<?php
interface PaymentGateway {
    public function pay($amount, $cardDetails);
}
