<?php
require __DIR__ . '/includes/auth.php';
require __DIR__ . '/config/db.php';

function h($value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
$error = '';
$editStudent = null;

if (empty($_SESSION['csrf_token'])) { $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $error = 'Security token mismatch. Refresh the page and try again.';
    } else {
        $action = $_POST['action'] ?? '';
        if ($action === 'delete') {
            $stmt = $pdo->prepare('DELETE FROM students WHERE id = ?');
            $stmt->execute([(int)($_POST['id'] ?? 0)]);
            header('Location: students.php?message=deleted'); exit;
        }
        if ($action === 'save') {
            $id = (int)($_POST['id'] ?? 0);
            $admission = trim($_POST['admission_no'] ?? '');
            $first = trim($_POST['first_name'] ?? '');
            $last = trim($_POST['last_name'] ?? '');
            $gender = $_POST['gender'] ?? '';
            $dob = $_POST['date_of_birth'] ?? '';
            $classId = ($_POST['class_id'] ?? '') !== '' ? (int)$_POST['class_id'] : null;
            $phone = trim($_POST['guardian_phone'] ?? '');
            $address = trim($_POST['address'] ?? '');
            if ($admission === '' || $first === '' || $last === '' || !in_array($gender, ['Male','Female','Other'], true)) {
                $error = 'Admission number, first name, last name and a valid gender are required.';
            } else {
                try {
                    if ($id > 0) {
                        $stmt = $pdo->prepare('UPDATE students SET admission_no=?, first_name=?, last_name=?, gender=?, date_of_birth=?, class_id=?, guardian_phone=?, address=? WHERE id=?');
                        $stmt->execute([$admission, $first, $last, $gender, $dob ?: null, $classId, $phone ?: null, $address ?: null, $id]);
                    } else {
                        $stmt = $pdo->prepare('INSERT INTO students (admission_no, first_name, last_name, gender, date_of_birth, class_id, guardian_phone, address) VALUES (?,?,?,?,?,?,?,?)');
                        $stmt->execute([$admission, $first, $last, $gender, $dob ?: null, $classId, $phone ?: null, $address ?: null]);
                    }
                    header('Location: students.php?message=saved'); exit;
                } catch (PDOException $e) {
                    $error = $e->getCode() === '23000' ? 'That admission number already exists. Use a unique number.' : 'Unable to save this student. Check the data and database connection.';
                }
            }
        }
    }
}

if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM students WHERE id=?');
    $stmt->execute([(int)$_GET['edit']]);
    $editStudent = $stmt->fetch() ?: null;
}
$classes = $pdo->query('SELECT id, class_name, stream FROM classes ORDER BY class_name')->fetchAll();
$students = $pdo->query('SELECT s.*, c.class_name FROM students s LEFT JOIN classes c ON c.id=s.class_id ORDER BY s.id DESC')->fetchAll();
$pageTitle = 'Manage Students';
require __DIR__ . '/includes/header.php';
?>
<?php if ($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>
<?php if (isset($_GET['message'])): ?><div class="alert alert-success"><?= $_GET['message'] === 'deleted' ? 'Student deleted.' : 'Student record saved.' ?></div><?php endif; ?>
<div class="card card-primary">
  <div class="card-header"><h3 class="card-title"><?= $editStudent ? 'Edit Student' : 'Add New Student' ?></h3></div>
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?= h($editStudent['id'] ?? '') ?>">
    <div class="card-body"><div class="row">
      <div class="form-group col-md-4"><label>Admission Number *</label><input class="form-control" name="admission_no" required value="<?= h($editStudent['admission_no'] ?? '') ?>" placeholder="e.g. SCH001"></div>
      <div class="form-group col-md-4"><label>First Name *</label><input class="form-control" name="first_name" required value="<?= h($editStudent['first_name'] ?? '') ?>"></div>
      <div class="form-group col-md-4"><label>Last Name *</label><input class="form-control" name="last_name" required value="<?= h($editStudent['last_name'] ?? '') ?>"></div>
      <div class="form-group col-md-3"><label>Gender *</label><select class="form-control" name="gender" required><option value="">Choose...</option><?php foreach (['Male','Female','Other'] as $g): ?><option value="<?= $g ?>" <?= (($editStudent['gender'] ?? '') === $g) ? 'selected' : '' ?>><?= $g ?></option><?php endforeach; ?></select></div>
      <div class="form-group col-md-3"><label>Date of Birth</label><input type="date" class="form-control" name="date_of_birth" value="<?= h($editStudent['date_of_birth'] ?? '') ?>"></div>
      <div class="form-group col-md-3"><label>Class</label><select class="form-control" name="class_id"><option value="">Not assigned</option><?php foreach ($classes as $c): ?><option value="<?= (int)$c['id'] ?>" <?= (string)($editStudent['class_id'] ?? '') === (string)$c['id'] ? 'selected' : '' ?>><?= h($c['class_name'].' '.($c['stream'] ?? '')) ?></option><?php endforeach; ?></select></div>
      <div class="form-group col-md-3"><label>Guardian Phone</label><input class="form-control" name="guardian_phone" value="<?= h($editStudent['guardian_phone'] ?? '') ?>" placeholder="e.g. 07..."></div>
      <div class="form-group col-md-12"><label>Address</label><input class="form-control" name="address" value="<?= h($editStudent['address'] ?? '') ?>"></div>
    </div></div>
    <div class="card-footer"><button class="btn btn-primary" type="submit"><?= $editStudent ? 'Update Student' : 'Save Student' ?></button><?php if ($editStudent): ?> <a class="btn btn-secondary" href="students.php">Cancel</a><?php endif; ?></div>
  </form>
</div>
<div class="card"><div class="card-header"><h3 class="card-title">Student Records (<?= count($students) ?>)</h3></div>
<div class="card-body table-responsive"><table class="table table-bordered table-striped"><thead><tr><th>Admission No.</th><th>Name</th><th>Gender</th><th>Class</th><th>Guardian Phone</th><th>Actions</th></tr></thead><tbody>
<?php if (!$students): ?><tr><td colspan="6" class="text-center">No students have been added yet.</td></tr><?php endif; ?>
<?php foreach ($students as $s): ?><tr><td><?= h($s['admission_no']) ?></td><td><?= h($s['first_name'].' '.$s['last_name']) ?></td><td><?= h($s['gender']) ?></td><td><?= h($s['class_name'] ?? 'Not assigned') ?></td><td><?= h($s['guardian_phone'] ?? '') ?></td><td class="text-nowrap"><a class="btn btn-sm btn-warning" href="students.php?edit=<?= (int)$s['id'] ?>"><i class="fas fa-edit"></i> Edit</a>
<form method="post" class="d-inline" onsubmit="return confirm('Delete this student record?');"><input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$s['id'] ?>"><button class="btn btn-sm btn-danger" type="submit"><i class="fas fa-trash"></i> Delete</button></form></td></tr><?php endforeach; ?>
</tbody></table></div></div>
<?php require __DIR__ . '/includes/footer.php'; ?>
