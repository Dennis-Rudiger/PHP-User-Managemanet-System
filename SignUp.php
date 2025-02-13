<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="SignUp.css">
    <title>Sign Up</title>
</head>
<body>
    <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        require('connection.php');
        $error_message = '';
        $success_message = '';

        if (isset($_POST['button'])){
            $name = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirmPassword'];
            
            switch(true) {
                case empty($name) || empty($email) || empty($password):
                    $error_message = 'Please fill all fields';
                    break;
                    
                case $password !== $confirmPassword:
                    $error_message = 'Passwords do not match';
                    break;
                    
                case strlen($password) < 6:
                    $error_message = 'Password must be at least 6 characters long';
                    break;

                default:
                    $conn = crud::connect();
                    if ($conn) {
                        try {
                            // Check if email already exists
                            $check = $conn->prepare('SELECT email FROM crudtable WHERE email = :e');
                            $check->bindValue(':e', $email);
                            $check->execute();
                            
                            if ($check->rowCount() > 0) {
                                $error_message = 'Email already exists';
                            } else {
                                // Hash password before storing
                                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                                
                                // Debug: Check if hash was created
                                if ($hashed_password === false) {
                                    $error_message = 'Password hashing failed';
                                    break;
                                }
                                
                                $p = $conn->prepare('INSERT INTO crudtable(name, email, pass) VALUES(:n, :e, :p)');
                                $p->bindValue(':n', $name);
                                $p->bindValue(':e', $email);
                                $p->bindValue(':p', $hashed_password);
                                
                                if ($p->execute()) {
                                    header('Location: login.php?registered=true');
                                    exit();
                                } else {
                                    $error_message = 'Failed to create account';
                                }
                            }
                        } catch (PDOException $e) {
                            $error_message = 'Database error: ' . $e->getMessage();
                        }
                    }
                    break;
            }
        }
    ?>
    <div class="form">
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="title">
                <p>Sign Up Form</p>
            </div>
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirmPassword" placeholder="Confirm Password" required>
            <input type="submit" value="Sign Up" name="button">
        </form>
    </div>
</body>
</html>
