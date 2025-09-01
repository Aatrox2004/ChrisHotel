<?php
require_once 'ReservationStrategy.php';

class GroupReservation implements ReservationStrategy {
    private $ratePerNight = 80; // Per person
    private $minimumPeopleForGroup = 3;

    public function calculatePrice($nights) {
        // Example logic for groups:
        // Groups have a base price per night per person
        // You can add more logic like discounts for large groups
        return $nights * $this->ratePerNight * $this->minimumPeopleForGroup;
    }
}
?>
