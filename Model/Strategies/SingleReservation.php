<?php
require_once 'ReservationStrategy.php';

class SingleReservation implements ReservationStrategy {
    private $ratePerNight = 100; // You can adjust this value

    public function calculatePrice($nights) {
        return $nights * $this->ratePerNight;
    }
}