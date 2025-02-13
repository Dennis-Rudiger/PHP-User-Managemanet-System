<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

// Include database connection
require('connection.php');

// Initialize message variables
$error_message = '';
$success_message = '';

// Check if user just registered
if (isset($_GET['registered'])) {
    $success_message = 'Registration successful! Please login with your credentials.';
}

// Check if user just logged out
if (isset($_GET['logout']) && $_GET['logout'] === 'success') {
    $success_message = 'You have been successfully logged out.';
}

// Check if login is required
if (isset($_GET['error']) && $_GET['error'] === 'login_required') {
    $error_message = 'Please login to access the dashboard.';
}

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if form is submitted
if (isset($_POST['button'])) {
    // Get and trim user input
    $email = trim($_POST['email'] ?? ''); // Avoid undefined index warning
    $password = $_POST['password'] ?? '';
    
    // Validate input
    if (empty($email) || empty($password)) {
        $error_message = 'Please fill in all fields';
    } else {
        // Get database connection
        $conn = crud::connect();
        
        if ($conn) {
            try {
                // Prepare SQL to prevent SQL injection
                $stmt = $conn->prepare('SELECT * FROM crudtable WHERE email = ?');
                $stmt->execute([$email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Check if user exists
                if ($user) {
                    // Debug
                    error_log('Stored hash: ' . $user['pass']);
                    error_log('Provided password: ' . $password);
                    
                    // Verify password
                    if (password_verify($password, $user['pass'])) {
                        // Set session variables
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['name'];
                        $_SESSION['email'] = $user['email'];
                        
                        // Redirect to dashboard
                        header('Location: dashboard.php');
                        exit();
                    } else {
                        $error_message = 'Invalid password';
                    }
                } else {
                    $error_message = 'Email not found';
                }
            } catch (PDOException $e) {
                $error_message = 'Database error: ' . $e->getMessage();
            }
        } else {
            $error_message = 'Unable to connect to database';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="Login.css">
</head>
<body>
    <div class="form">
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>
        
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="title">
                <p>Login Form</p>
            </div>
            <input type="email" 
                   name="email" 
                   placeholder="Enter your email address" 
                   required 
                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            <input type="password" 
                   name="password" 
                   placeholder="Enter your password" 
                   required>
            <input type="submit" value="Log In" name="button">
            
            <!-- Add link to signup page -->
            <p class="signup-link">Don't have an account? <a href="SignUp.php">Sign Up</a></p>
        </form>
    </div>
</body>
</html>