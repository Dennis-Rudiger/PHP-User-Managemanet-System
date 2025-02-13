<?php
require_once 'auth_check.php';
$success_message = $_GET['success'] ?? '';
$error_message = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <nav class="dashboard-nav">
            <div class="nav-header">
                <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
            </div>
            <div class="nav-user">
                <span class="user-greeting"><i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <form action="logout.php" method="POST" class="logout-form">
                    <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </nav>

        <?php if ($success_message): ?>
            <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <main class="dashboard-main">
            <div class="dashboard-cards">
                <div class="card profile-card">
                    <h3><i class="fas fa-user-circle"></i> Profile Info</h3>
                    <div class="card-content">
                        <div class="profile-info">
                            <p><i class="fas fa-user"></i> <strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                            <p><i class="fas fa-envelope"></i> <strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                        </div>
                        <button class="action-btn edit-profile-btn"><i class="fas fa-edit"></i> Edit Profile</button>
                        <button class="action-btn change-password-btn"><i class="fas fa-key"></i> Change Password</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Profile</h2>
            <form id="editProfileForm" action="update_profile.php" method="POST">
                <input type="text" name="username" placeholder="New Username" 
                    value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required>
                <input type="email" name="email" placeholder="New Email" 
                    value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
                <button type="submit" class="action-btn"><i class="fas fa-save"></i> Save Changes</button>
            </form>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div id="changePasswordModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Change Password</h2>
            <form id="changePasswordForm" action="update_password.php" method="POST">
                <input type="password" name="current_password" placeholder="Current Password" required>
                <input type="password" name="new_password" placeholder="New Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
                <button type="submit" class="action-btn"><i class="fas fa-key"></i> Update Password</button>
            </form>
        </div>
    </div>

    <script src="dashboard.js"></script>
</body>
</html>