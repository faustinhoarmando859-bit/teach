<?php
require_once __DIR__ . '/../includes/auth.php';
require_role(['admin']);
$users=$pdo->query('SELECT id,full_name,email,role,created_at FROM users ORDER BY created_at DESC')->fetchAll();
$pageTitle='User Accounts';require __DIR__.'/../includes/header.php';
?>
<div class="card"><div class="card-header"><h3 class="card-title">Registered users</h3></div><div class="card-body table-responsive"><p>New accounts register as ordinary users. To promote a trusted account to technician, update its role using phpMyAdmin (SQL example in README below).</p>
<table class="table table-bordered table-hover"><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Created</th></tr></thead><tbody>
<?php foreach($users as $u): ?><tr><td><?=$u['id']?></td><td><?=e($u['full_name'])?></td><td><?=e($u['email'])?></td><td><span class="badge badge-info"><?=e($u['role'])?></span></td><td><?=e($u['created_at'])?></td></tr><?php endforeach; ?></tbody></table>
<div class="alert alert-secondary mb-0"><b>Promote a user to technician:</b> In phpMyAdmin, open the ict_helpdesk database, select SQL, and run:<br><code>UPDATE users SET role='technician' WHERE email='technician@example.com';</code><br>Replace the email with the registered account's email.</div></div></div>
<?php require __DIR__.'/../includes/footer.php'; ?>
