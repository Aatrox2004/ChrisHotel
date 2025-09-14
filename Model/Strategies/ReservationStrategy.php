<?php
interface ReservationStrategy {
    public function calculatePrice($nights, $adults, $children, $roomPrice);
}