<?php
require __DIR__ . '/config/db.php';
$stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
$stmt->execute(['admin']);
if ($stmt->fetch()) {
    exit('An admin account already exists. Delete setup_admin.php now and go to login.php.');
}
$hash = password_hash('admin123', PASSWORD_DEFAULT);
$stmt = $pdo->prepare('INSERT INTO users (username, password_hash, full_name, role) VALUES (?, ?, ?, ?)');
$stmt->execute(['admin', $hash, 'System Administrator', 'admin']);
echo 'Admin account created. Username: admin | Password: admin123. DELETE setup_admin.php now, then log in.';
