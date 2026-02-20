<?php
session_start();

// This is basically the "gatekeeper" for protected pages. 
// If the user isn't logged in, they shouldn't be here.

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");

// If there's no user_id in the session, it means the user is not logged in
// So we send them back to the login page.
    exit;
}
?>
