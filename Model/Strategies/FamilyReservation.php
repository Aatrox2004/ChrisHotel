<?php
require_once 'ReservationStrategy.php';

class FamilyReservation implements ReservationStrategy {
    private $discount = 0.20;

    public function calculatePrice($nights, $adults, $children, $roomPrice) {
        return $nights * $roomPrice * (1 - $this->discount);
    }
}