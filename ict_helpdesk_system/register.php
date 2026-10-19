<?php
require_once __DIR__ . '/includes/auth.php';
if (current_user()) { header('Location: dashboard.php'); exit; }
$error = ''; $success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
        $error = 'Enter your name, a valid email, and a password with at least 8 characters.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (full_name,email,password_hash,role) VALUES (?,?,?,'user')");
            $stmt->execute([$name,$email,password_hash($password,PASSWORD_DEFAULT)]);
            $success = 'Account created. You can now sign in.';
        } catch (PDOException $ex) { $error = 'That email may already be registered.'; }
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Register | ICT Helpdesk</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css"></head>
<body class="hold-transition register-page"><div class="register-box"><div class="register-logo"><b>ICT</b> Helpdesk</div><div class="card"><div class="card-body register-card-body">
<p class="login-box-msg">Create a user account</p><?php if($error): ?><div class="alert alert-danger"><?=e($error)?></div><?php endif; ?><?php if($success): ?><div class="alert alert-success"><?=e($success)?></div><?php endif; ?>
<form method="post">
<div class="input-group mb-3"><input name="full_name" class="form-control" placeholder="Full name" required><div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div></div>
<div class="input-group mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required><div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div></div>
<div class="input-group mb-3"><input type="password" name="password" class="form-control" placeholder="Password (8+ characters)" minlength="8" required><div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div></div>
<button type="submit" class="btn btn-primary btn-block">Register</button></form><p class="mt-3 mb-0"><a href="login.php">I already have an account</a></p></div></div></div></body></html>
