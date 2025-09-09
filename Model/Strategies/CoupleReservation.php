<?php
require_once 'ReservationStrategy.php';

class CoupleReservation implements ReservationStrategy {
    private $ratePerNight = 180; // per couple per night

    public function calculatePrice($nights, $guests) {
        return $nights * $this->ratePerNight; // fixed for couple
    }
}
