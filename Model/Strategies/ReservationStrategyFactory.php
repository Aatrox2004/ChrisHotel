<?php
require_once 'SingleReservation.php';
require_once 'GroupReservation.php';
require_once 'FamilyReservation.php';

class ReservationStrategyFactory {
    public static function create($adults, $children) {
        if ($adults == 1 && $children == 0) {
            return new SingleReservation();
        }
        if ($adults > 1 && $children == 0) {
            return new GroupReservation();
        }
        if ($children > 0) {
            return new FamilyReservation();
        }
        return new SingleReservation();
    }
}
