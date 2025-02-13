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
                            <div class="profile-picture">
                                <img src="<?php echo !empty($_SESSION['avatar']) ? htmlspecialchars('uploads/avatars/' . $_SESSION['avatar']) : 'assets/default-avatar.png'; ?>" 
                                     alt="Profile Picture">
                                <button type="button" class="change-avatar-btn" title="Change profile picture">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </div>
                            <p><i class="fas fa-user"></i> <strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                            <p><i class="fas fa-envelope"></i> <strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                        </div>
                        <button class="action-btn edit-profile-btn"><i class="fas fa-edit"></i> Edit Profile</button>
                        <button class="action-btn change-password-btn"><i class="fas fa-key"></i> Change Password</button>
                        <button class="action-btn delete-account-btn" style="background-color: #dc3545;">
                            <i class="fas fa-trash-alt"></i> Delete Account
                        </button>
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

    <!-- Avatar Modal -->
    <div id="avatarModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Change Profile Picture</h2>
            <form id="avatarForm" action="update_avatar.php" method="POST" enctype="multipart/form-data">
                <div class="file-input-wrapper">
                    <input type="file" name="avatar" accept="image/*" required>
                    <p class="file-help">Maximum size: 5MB. Accepted formats: JPG, PNG, GIF</p>
                </div>
                <button type="submit" class="action-btn">
                    <i class="fas fa-upload"></i> Upload Picture
                </button>
            </form>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div id="deleteAccountModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Delete Account</h2>
            <div class="warning-box">
                <i class="fas fa-exclamation-triangle"></i>
                <p>Warning: This action cannot be undone. All your data will be permanently deleted.</p>
            </div>
            <form id="deleteAccountForm" action="delete_account.php" method="POST">
                <input type="password" name="password" placeholder="Enter your password to confirm" required>
                <button type="submit" class="action-btn delete-btn">
                    <i class="fas fa-trash-alt"></i> Permanently Delete Account
                </button>
            </form>
        </div>
    </div>

    <script src="dashboard.js"></script>
</body>
</html>