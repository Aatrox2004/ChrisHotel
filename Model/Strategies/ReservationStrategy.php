<?php
interface ReservationStrategy {
    public function calculatePrice($nights, $guests);
}