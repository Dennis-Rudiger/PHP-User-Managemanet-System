<?php
require_once 'auth_check.php';
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $file = $_FILES['avatar'];
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 5 * 1024 * 1024; // 5MB
    
    if (!in_array($file['type'], $allowed_types)) {
        header('Location: dashboard.php?error=Invalid file type. Please upload an image');
        exit();
    }
    
    if ($file['size'] > $max_size) {
        header('Location: dashboard.php?error=File too large. Maximum size is 5MB');
        exit();
    }
    
    // Create uploads directory if it doesn't exist
    $upload_dir = 'uploads/avatars';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    // Generate unique filename
    $filename = uniqid() . '_' . basename($file['name']);
    $filepath = $upload_dir . '/' . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        $conn = crud::connect();
        try {
            // Delete old avatar if exists
            if (!empty($_SESSION['avatar'])) {
                $old_avatar = $upload_dir . '/' . $_SESSION['avatar'];
                if (file_exists($old_avatar)) {
                    unlink($old_avatar);
                }
            }
            
            // Update database
            $stmt = $conn->prepare('UPDATE crudtable SET avatar = ? WHERE id = ?');
            if ($stmt->execute([$filename, $_SESSION['user_id']])) {
                $_SESSION['avatar'] = $filename;
                header('Location: dashboard.php?success=Profile picture updated successfully');
            } else {
                header('Location: dashboard.php?error=Failed to update profile picture');
            }
        } catch (PDOException $e) {
            header('Location: dashboard.php?error=' . urlencode('Database error: ' . $e->getMessage()));
        }
    } else {
        header('Location: dashboard.php?error=Failed to upload file');
    }
    exit();
}
