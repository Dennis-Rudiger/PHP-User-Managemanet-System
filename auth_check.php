<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page with a message indicating the user needs to login
    header('Location: login.php?error=login_required');
    exit();
}
?> 