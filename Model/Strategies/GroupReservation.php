<?php
require_once 'ReservationStrategy.php';

class GroupReservation implements ReservationStrategy {
    private $ratePerNight = 80; // per guest

    public function calculatePrice($nights, $guests) {
        return $nights * $this->ratePerNight * $guests;
    }
}

