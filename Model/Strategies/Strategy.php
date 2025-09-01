<?php
ob_start();
date_default_timezone_set('Asia/Singapore');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once '../Entity/ReservationEntity.php';
require_once './SingleReservation.php';
require_once './CoupleReservation.php';
require_once './GroupReservation.php';

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

error_log("Received POST at " . date('Y-m-d H:i:s') . ": " . print_r($_POST, true));

$name = sanitizeInput($_POST['name'] ?? '');
$checkin = sanitizeInput($_POST['checkin'] ?? '');
$checkout = sanitizeInput($_POST['checkout'] ?? '');
$room = sanitizeInput($_POST['room'] ?? '');
$guests = intval($_POST['guests'] ?? 0);

if (empty($name) || empty($checkin) || empty($checkout) || $guests < 1) {
    error_log("Invalid input at " . date('Y-m-d H:i:s') . ": name=$name, checkin=$checkin, checkout=$checkout, guests=$guests");
    die("Invalid input. Please check your details.");
}

try {
    $checkinDate = new DateTime($checkin);
    $checkoutDate = new DateTime($checkout);
} catch (Exception $e) {
    error_log("DateTime error at " . date('Y-m-d H:i:s') . ": " . $e->getMessage());
    die("Invalid date format.");
}

$interval = $checkinDate->diff($checkoutDate);
$nights = $interval->days;
if ($nights <= 0) {
    error_log("Invalid date range at " . date('Y-m-d H:i:s') . ": checkin=$checkin, checkout=$checkout");
    die("Check-out date must be after check-in date.");
}

if ($guests === 1) {
    $strategy = new SingleReservation();
} elseif ($guests === 2) {
    $strategy = new CoupleReservation();
} else {
    $strategy = new GroupReservation();
}

$totalPrice = $strategy->calculatePrice($nights);

$reservation = new ReservationEntity($name, $checkin, $checkout, $guests, $totalPrice);
$booking = [
    'name' => $name,
    'checkin' => $checkin,
    'checkout' => $checkout,
    'room' => $room,
    'guests' => $guests,
    'nights' => $nights,
    'total' => $totalPrice
];

$_SESSION['booking'] = $booking;
$_SESSION['total'] = round($totalPrice, 2);

error_log("Session data set at " . date('Y-m-d H:i:s') . ": " . print_r($_SESSION, true));
error_log("Redirecting to ../Payment.php at " . date('Y-m-d H:i:s'));

ob_end_flush();
header("Location: ../Payment.php");
exit();