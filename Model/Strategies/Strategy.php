<?php
require_once __DIR__ . '/../../Config.php';
ob_start();
session_start();

$timeout_duration = 900;
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: " . BASE_URL . "index.php?url=User/Login&message=SessionExpired");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();

date_default_timezone_set('Asia/Singapore');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../Entity/ReservationEntity.php';
require_once './SingleReservation.php';
require_once './CoupleReservation.php';
require_once './GroupReservation.php';

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function validateReservationInput($name, $checkin, $checkout, $guests) {
    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        return "Invalid name format. Letters and spaces only.";
    }
    if (!filter_var($guests, FILTER_VALIDATE_INT) || $guests < 1 || $guests > 5) {
        return "Invalid number of guests.";
    }
    if (!strtotime($checkin) || !strtotime($checkout)) {
        return "Invalid date format.";
    }
    if (strtotime($checkin) >= strtotime($checkout)) {
        return "Check-out date must be after check-in date.";
    }
    return null;
}

error_log("Received POST at " . date('Y-m-d H:i:s') . ": " . print_r($_POST, true));

$name = sanitizeInput($_POST['name'] ?? '');
$checkin = sanitizeInput($_POST['checkin'] ?? '');
$checkout = sanitizeInput($_POST['checkout'] ?? '');
$room = sanitizeInput($_POST['room'] ?? '');
$guests = intval($_POST['guests'] ?? 0);

$error = validateReservationInput($name, $checkin, $checkout, $guests);
if ($error) {
    error_log("Validation error: " . $error);
    die($error);
}

$checkinDate = new DateTime($checkin);
$checkoutDate = new DateTime($checkout);
$nights = $checkinDate->diff($checkoutDate)->days;

if ($guests === 1) {
    $strategy = new SingleReservation();
} elseif ($guests === 2) {
    $strategy = new CoupleReservation();
} else {
    $strategy = new GroupReservation();
}

$totalPrice = $strategy->calculatePrice($nights, $guests);

$reservation = new ReservationEntity($name, $checkin, $checkout, $guests, $totalPrice);

$_SESSION['booking'] = [
    'name' => $name,
    'checkin' => $checkin,
    'checkout' => $checkout,
    'room' => $room,
    'guests' => $guests,
    'nights' => $nights,
    'total' => $totalPrice
];
$_SESSION['total'] = round($totalPrice, 2);

error_log("Session data set: " . print_r($_SESSION, true));

ob_clean();
header("Location: " . BASE_URL . "index.php?url=Payment");
exit();
?>
