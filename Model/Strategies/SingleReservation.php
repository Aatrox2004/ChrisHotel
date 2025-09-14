<?php
require_once 'ReservationStrategy.php';

class SingleReservation implements ReservationStrategy {
    public function calculatePrice($nights, $adults, $children, $roomPrice) {
        return $nights * $roomPrice;
    }
}