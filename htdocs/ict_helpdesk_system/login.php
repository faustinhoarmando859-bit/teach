<?php
require_once __DIR__ . '/includes/auth.php';
if (current_user()) { header('Location: dashboard.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT id, full_name, email, password_hash, role FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $row = $stmt->fetch();
    if ($row && password_verify($password, $row['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id'=>(int)$row['id'], 'full_name'=>$row['full_name'], 'email'=>$row['email'], 'role'=>$row['role']];
        header('Location: dashboard.php'); exit;
    }
    $error = 'Invalid email or password.';
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login | ICT Helpdesk</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css"></head>
<body class="hold-transition login-page"><div class="login-box"><div class="login-logo"><b>ICT</b> Helpdesk</div>
<div class="card"><div class="card-body login-card-body"><p class="login-box-msg">Sign in to start your session</p>
<?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<form method="post">
<div class="input-group mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required><div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div></div>
<div class="input-group mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required><div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div></div>
<button type="submit" class="btn btn-primary btn-block">Sign In</button></form>
<p class="mt-3 mb-0"><a href="register.php">Register a user account</a></p></div></div></div>
</body></html>
