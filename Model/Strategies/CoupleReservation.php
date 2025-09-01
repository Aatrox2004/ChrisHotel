<?php
require_once 'ReservationStrategy.php';

class CoupleReservation implements ReservationStrategy {
    private $ratePerNight = 180; // Slightly discounted rate for couples

    public function calculatePrice($nights) {
        return $nights * $this->ratePerNight;
    }
}