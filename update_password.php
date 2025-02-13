<?php
require_once 'auth_check.php';
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $userId = $_SESSION['user_id'];

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        header('Location: dashboard.php?error=Please fill all password fields');
        exit();
    }

    if ($new_password !== $confirm_password) {
        header('Location: dashboard.php?error=New passwords do not match');
        exit();
    }

    if (strlen($new_password) < 6) {
        header('Location: dashboard.php?error=Password must be at least 6 characters long');
        exit();
    }

    $conn = crud::connect();
    
    try {
        // Verify current password
        $stmt = $conn->prepare('SELECT pass FROM crudtable WHERE id = ?');
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($current_password, $user['pass'])) {
            header('Location: dashboard.php?error=Current password is incorrect');
            exit();
        }

        // Update password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('UPDATE crudtable SET pass = ? WHERE id = ?');
        
        if ($stmt->execute([$hashed_password, $userId])) {
            header('Location: dashboard.php?success=Password updated successfully');
        } else {
            header('Location: dashboard.php?error=Failed to update password');
        }
    } catch (PDOException $e) {
        header('Location: dashboard.php?error=' . urlencode('Database error: ' . $e->getMessage()));
    }
    exit();
}
