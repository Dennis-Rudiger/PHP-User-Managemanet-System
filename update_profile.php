<?php
require_once 'auth_check.php';
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $userId = $_SESSION['user_id'];

    if (empty($username) || empty($email)) {
        header('Location: dashboard.php?error=Please fill all fields');
        exit();
    }

    $conn = crud::connect();
    
    try {
        // Check if email is already taken by another user
        $stmt = $conn->prepare('SELECT id FROM crudtable WHERE email = ? AND id != ?');
        $stmt->execute([$email, $userId]);
        
        if ($stmt->rowCount() > 0) {
            header('Location: dashboard.php?error=Email already exists');
            exit();
        }

        // Update profile
        $stmt = $conn->prepare('UPDATE crudtable SET name = ?, email = ? WHERE id = ?');
        if ($stmt->execute([$username, $email, $userId])) {
            // Update session variables
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            
            header('Location: dashboard.php?success=Profile updated successfully');
        } else {
            header('Location: dashboard.php?error=Failed to update profile');
        }
    } catch (PDOException $e) {
        header('Location: dashboard.php?error=' . urlencode('Database error: ' . $e->getMessage()));
    }
    exit();
}
