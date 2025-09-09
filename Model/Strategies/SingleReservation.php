<?php
require_once 'ReservationStrategy.php';

class SingleReservation implements ReservationStrategy {
    private $ratePerNight = 100;

    public function calculatePrice($nights, $guests) {
        return $nights * $this->ratePerNight; // guests always 1
    }
}