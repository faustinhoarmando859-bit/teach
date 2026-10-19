<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/config/db.php';
function h($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
$error = '';
if (empty($_SESSION['csrf_token'])) { $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $error = 'Security token mismatch. Refresh and try again.';
    } else {
        $name = trim($_POST['class_name'] ?? '');
        $stream = trim($_POST['stream'] ?? '');
        if ($name === '') { $error = 'Class name is required.'; }
        else {
            try {
                $stmt = $pdo->prepare('INSERT INTO classes (class_name, stream) VALUES (?, ?)');
                $stmt->execute([$name, $stream ?: null]);
                header('Location: classes.php?message=saved'); exit;
            } catch (PDOException $e) {
                $error = $e->getCode() === '23000' ? 'That class name already exists.' : 'Unable to save class.';
            }
        }
    }
}
$classes = $pdo->query('SELECT c.id, c.class_name, c.stream, COUNT(s.id) AS student_count FROM classes c LEFT JOIN students s ON s.class_id=c.id GROUP BY c.id, c.class_name, c.stream ORDER BY c.class_name')->fetchAll();
$pageTitle = 'Manage Classes';
require __DIR__ . '/includes/header.php';
?>
<?php if ($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>
<?php if (isset($_GET['message'])): ?><div class="alert alert-success">Class saved successfully.</div><?php endif; ?>
<div class="card card-primary"><div class="card-header"><h3 class="card-title">Add Class</h3></div>
<form method="post"><div class="card-body"><input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">
<div class="row"><div class="form-group col-md-6"><label>Class Name *</label><input class="form-control" name="class_name" required placeholder="e.g. Form Five"></div>
<div class="form-group col-md-6"><label>Stream (optional)</label><input class="form-control" name="stream" placeholder="e.g. A"></div></div></div>
<div class="card-footer"><button class="btn btn-primary" type="submit">Save Class</button></div></form></div>
<div class="card"><div class="card-header"><h3 class="card-title">Class List</h3></div><div class="card-body table-responsive">
<table class="table table-bordered table-striped"><thead><tr><th>#</th><th>Class</th><th>Stream</th><th>Students</th></tr></thead><tbody>
<?php foreach ($classes as $c): ?><tr><td><?= (int)$c['id'] ?></td><td><?= h($c['class_name']) ?></td><td><?= h($c['stream'] ?? '-') ?></td><td><?= (int)$c['student_count'] ?></td></tr><?php endforeach; ?>
</tbody></table></div></div>
<?php require __DIR__ . '/includes/footer.php'; ?>
