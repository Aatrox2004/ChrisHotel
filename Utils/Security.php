<?php
// Utils/Security.php
function start_secure_session(int $timeout = 1800) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start([
            'cookie_httponly' => true,
            'cookie_secure' => isset($_SERVER['HTTPS']),
            'cookie_samesite' => 'Lax',
        ]);
    }
    $now = time();
    if (isset($_SESSION['LAST_ACTIVITY']) && ($now - $_SESSION['LAST_ACTIVITY']) > $timeout) {
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['session_expired'] = true;
    }
    $_SESSION['LAST_ACTIVITY'] = $now;

    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
}

function verify_csrf(string $token): bool {
    return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}
