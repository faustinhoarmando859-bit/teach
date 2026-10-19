<?php
require_once __DIR__ . '/config/database.php';
$email = 'admin@icthelpdesk.local';
$stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
$stmt->execute([$email]);
if ($stmt->fetch()) {
    exit('Admin already exists. Delete setup_admin.php now and sign in at login.php.');
}
$hash = password_hash('Admin@123', PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, 'admin')");
$stmt->execute(['System Administrator', $email, $hash]);
echo 'Admin created successfully.<br>Email: admin@icthelpdesk.local<br>Password: Admin@123<br><b>Delete setup_admin.php now for security.</b>';
