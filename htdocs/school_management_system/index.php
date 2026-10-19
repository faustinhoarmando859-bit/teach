<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/config/db.php';
$studentCount = (int)$pdo->query('SELECT COUNT(*) FROM students')->fetchColumn();
$classCount = (int)$pdo->query('SELECT COUNT(*) FROM classes')->fetchColumn();
$userCount = (int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
$recent = $pdo->query('SELECT s.admission_no, s.first_name, s.last_name, c.class_name FROM students s LEFT JOIN classes c ON c.id=s.class_id ORDER BY s.id DESC LIMIT 5')->fetchAll();
$pageTitle = 'Dashboard';
require __DIR__ . '/includes/header.php';
?>
<div class="row">
  <div class="col-lg-4 col-6"><div class="small-box bg-info"><div class="inner"><h3><?= $studentCount ?></h3><p>Total Students</p></div><div class="icon"><i class="fas fa-user-graduate"></i></div><a href="students.php" class="small-box-footer">Manage students <i class="fas fa-arrow-circle-right"></i></a></div></div>
  <div class="col-lg-4 col-6"><div class="small-box bg-success"><div class="inner"><h3><?= $classCount ?></h3><p>Total Classes</p></div><div class="icon"><i class="fas fa-school"></i></div><a href="classes.php" class="small-box-footer">View classes <i class="fas fa-arrow-circle-right"></i></a></div></div>
  <div class="col-lg-4 col-6"><div class="small-box bg-warning"><div class="inner"><h3><?= $userCount ?></h3><p>System Users</p></div><div class="icon"><i class="fas fa-users-cog"></i></div><a href="#" class="small-box-footer">Administrator overview</a></div></div>
</div>
<div class="card"><div class="card-header"><h3 class="card-title">Recently Added Students</h3><a href="students.php" class="btn btn-primary btn-sm float-right">Manage Students</a></div>
<div class="card-body table-responsive p-0"><table class="table table-hover text-nowrap"><thead><tr><th>Admission No.</th><th>Student Name</th><th>Class</th></tr></thead><tbody>
<?php if (!$recent): ?><tr><td colspan="3" class="text-center">No students yet. Use Manage Students to add your first student.</td></tr><?php endif; ?>
<?php foreach ($recent as $s): ?><tr><td><?= htmlspecialchars($s['admission_no']) ?></td><td><?= htmlspecialchars($s['first_name'].' '.$s['last_name']) ?></td><td><?= htmlspecialchars($s['class_name'] ?? 'Not assigned') ?></td></tr><?php endforeach; ?>
</tbody></table></div></div>
<?php require __DIR__ . '/includes/footer.php'; ?>
