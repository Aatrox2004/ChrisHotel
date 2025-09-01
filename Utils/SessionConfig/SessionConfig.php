<?php
$timeout_duration = 10; // seconds

// Check if user has been inactive for too long
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: Home.html");
    exit();
}

$_SESSION['LAST_ACTIVITY'] = time(); // update last activity
