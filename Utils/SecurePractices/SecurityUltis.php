<?php
// 🔒 Secure Input Handling
function clean_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function validate_amount($amount) {
    return filter_var($amount, FILTER_VALIDATE_FLOAT) && $amount > 0;
}

function validate_card($card) {
    return preg_match('/^[0-9]{16}$/', $card); // 16-digit card number
}

function validate_expiry($expiry) {
    return preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $expiry); // MM/YY
}

function validate_cvv($cvv) {
    return preg_match('/^[0-9]{3}$/', $cvv); // 3-digit CVV
}

// 🔒 Session Security
function secure_session_start() {
    if (session_status() == PHP_SESSION_NONE) {
        ini_set('session.cookie_httponly', 1);
        ini_set('session.cookie_secure', 1);
        ini_set('session.use_strict_mode', 1);
        session_start();
    }
}

// 🔒 Error Handling
function log_error($message) {
    error_log("[PaymentModule] " . $message);
}
