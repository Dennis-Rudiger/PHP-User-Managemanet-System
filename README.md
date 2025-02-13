# PHP User Management System

A comprehensive user management system built with PHP, MySQL, and JavaScript, featuring secure authentication, profile management, and avatar upload functionality.

## Features

- 🔐 Secure User Authentication
- 👤 Profile Management
- 🖼️ Avatar Upload System
- 🔑 Password Change
- ⚠️ Account Deletion
- 📱 Responsive Design
- 🛡️ SQL Injection Protection
- 🔒 Password Hashing

## Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache Web Server
- XAMPP/WAMP/MAMP

## Installation

1. Clone the repository:
```bash
git clone https://github.com/Dennis-Rudiger/php-user-management.git
```

2. Import the database schema:
```sql
CREATE DATABASE crud_app;
USE crud_app;

CREATE TABLE crudtable (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    pass VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

3. Configure database connection:
- Open `connection.php`
- Update credentials if needed

4. Set up file permissions:
```bash
mkdir uploads/avatars
chmod 777 uploads/avatars
```

5. Create default avatar:
```bash
mkdir assets
# Add a default-avatar.png file to the assets folder
```

## Usage

1. Access the application:
```
http://localhost/Crud App/
```

2. Register a new account
3. Log in with your credentials
4. Manage your profile:
   - Update profile information
   - Change avatar
   - Update password
   - Delete account

## Security Features

- Password Hashing (using PHP's password_hash)
- PDO Prepared Statements
- Session Management
- Input Validation
- File Upload Validation
- XSS Protection
- CSRF Protection (via session tokens)

## Directory Structure

```
Crud App/
├── assets/
│   └── default-avatar.png
├── uploads/
│   └── avatars/
├── auth_check.php
├── connection.php
├── dashboard.php
├── dashboard.css
├── dashboard.js
├── delete_account.php
├── login.php
├── Login.css
├── logout.php
├── SignUp.php
├── SignUp.css
├── update_avatar.php
├── update_password.php
└── update_profile.php
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## Acknowledgments

- Font Awesome for icons
- Bootstrap for design inspiration
