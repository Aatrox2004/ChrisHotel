<?php
function secure_session_start() {
    $session_name = 'secure_session';
    $secure = false; // set to true in production with HTTPS
    $httponly = true;

    ini_set('session.use_only_cookies', 1);
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params([
        'lifetime' => $cookieParams['lifetime'],
        'path' => $cookieParams['path'],
        'domain' => $cookieParams['domain'],
        'secure' => $secure,
        'httponly' => $httponly,
        'samesite' => 'Strict'
    ]);

    session_name($session_name);
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function clean_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function validate_amount($amount) {
    return is_numeric($amount) && $amount > 0;
}

/**
 * Validate Malaysian payment cards:
 * - Visa (starts with 4, 16 digits)
 * - MasterCard (starts with 51–55, 16 digits)
 * - AMEX (starts with 34 or 37, 15 digits)
 */
function validate_card($card) {
    $card = preg_replace('/\s+/', '', $card); // remove spaces

    // Visa: 16 digits starting with 4
    if (preg_match("/^4[0-9]{15}$/", $card)) {
        return true;
    }

    // MasterCard: 16 digits starting with 51–55
    if (preg_match("/^5[1-5][0-9]{14}$/", $card)) {
        return true;
    }

    // AMEX: 15 digits starting with 34 or 37
    if (preg_match("/^3[47][0-9]{13}$/", $card)) {
        return true;
    }

    return false; // not a supported Malaysian card
}

/**
 * Expiry date (MM/YY or MM/YYYY)
 */
function validate_expiry($expiry) {
    if (!preg_match("/^(0[1-9]|1[0-2])\/(\d{2}|\d{4})$/", $expiry)) {
        return false;
    }

    // Ensure date is not expired
    $parts = explode("/", $expiry);
    $month = (int)$parts[0];
    $year = (int)(strlen($parts[1]) == 2 ? "20" . $parts[1] : $parts[1]);

    $currentYear = (int)date("Y");
    $currentMonth = (int)date("m");

    return ($year > $currentYear) || ($year == $currentYear && $month >= $currentMonth);
}

/**
 * CVV validation:
 * - Visa/MasterCard: 3 digits
 * - AMEX: 4 digits
 */
function validate_cvv($cvv) {
    return preg_match("/^[0-9]{3,4}$/", $cvv);
}

/**
 * Log errors securely
 */
function log_error($message) {
    $logDir = __DIR__ . '/../../logs';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0777, true);
    }
    $file = $logDir . "/errors.log";
    $entry = "[" . date("Y-m-d H:i:s") . "] " . $message . PHP_EOL;
    file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);
}
