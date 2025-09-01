<?php
class ReservationEntity {
    private $custName;
    private $reservationId;
    private $checkInDate;
    private $checkOutDate;
    private $pax;
    private $reservationType;
    private $price;

    public function __construct($custName, $checkInDate, $checkOutDate, $pax, $price) {
        $this->custName = $custName;
        $this->reservationId = uniqid('RES-');
        $this->checkInDate = $checkInDate;
        $this->checkOutDate = $checkOutDate;
        $this->pax = $pax;
        $this->reservationType = $this->getTypeFromPax($pax);
        $this->price = $price;
    }

    public function getcustName(){return $this->custName;}
    public function getReservationId(){return $this->reservationId;}
    public function getCheckInDate(){return $this->checkInDate;}
    public function getCheckOutDate(){return $this->checkOutDate;}
    public function getPax(){return $this->pax;}
    public function getReservationType(){return $this->reservationType;}
    public function getPrice(){return $this->price;}
    
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    private function getTypeFromPax($pax) {
        if ($pax == 1) return "Single";
        if ($pax == 2) return "Couple";
        return "Group";
    }

    public function __toString()
    {
        return __CLASS__ ."Customer Name:  {$this->custName}, Reservation ID: {$this->reservationId}, Check In Date: {$this->checkInDate}, Check Out Date: {$this->checkOutDate}, Pax: {$this->pax}, Reservation Type: {$this->reservationType}, Price: {$this->price}";
    }
}
