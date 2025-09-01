<?php
session_start();
session_destroy(); // Destroy all session data
header("Location: Login.php"); // Redirect to login page
exit();
?>