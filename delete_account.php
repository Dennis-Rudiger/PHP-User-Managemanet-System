<?php
require_once 'auth_check.php';
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $userId = $_SESSION['user_id'];

    if (empty($password)) {
        header('Location: dashboard.php?error=Password required to delete account');
        exit();
    }

    $conn = crud::connect();
    try {
        // Verify password
        $stmt = $conn->prepare('SELECT pass FROM crudtable WHERE id = ?');
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['pass'])) {
            // Delete avatar file if exists
            if (!empty($_SESSION['avatar'])) {
                $avatar_path = 'uploads/avatars/' . $_SESSION['avatar'];
                if (file_exists($avatar_path)) {
                    unlink($avatar_path);
                }
            }

            // Delete user account
            $stmt = $conn->prepare('DELETE FROM crudtable WHERE id = ?');
            if ($stmt->execute([$userId])) {
                // Clear session and redirect to login
                session_destroy();
                header('Location: login.php?message=Account successfully deleted');
            } else {
                header('Location: dashboard.php?error=Failed to delete account');
            }
        } else {
            header('Location: dashboard.php?error=Incorrect password');
        }
    } catch (PDOException $e) {
        header('Location: dashboard.php?error=' . urlencode('Database error: ' . $e->getMessage()));
    }
    exit();
}
