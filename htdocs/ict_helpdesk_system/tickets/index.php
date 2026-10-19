<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$where = ticket_visible_sql();
$sql = "SELECT t.*, u.full_name AS reporter, c.name AS category, tech.full_name AS technician
        FROM tickets t JOIN users u ON u.id=t.user_id JOIN categories c ON c.id=t.category_id
        LEFT JOIN users tech ON tech.id=t.technician_id WHERE $where ORDER BY t.created_at DESC";
$tickets = $pdo->query($sql)->fetchAll();
$pageTitle = 'Tickets';
require __DIR__ . '/../includes/header.php';
?>
<div class="card"><div class="card-header"><h3 class="card-title">Ticket list</h3><div class="card-tools"><a href="create.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Report Ticket</a></div></div>
<div class="card-body table-responsive"><table class="table table-bordered table-hover"><thead><tr><th>Ticket</th><th>Title</th><th>Category</th><th>Reporter</th><th>Priority</th><th>Status</th><th>Technician</th><th>Created</th><th></th></tr></thead><tbody>
<?php if(!$tickets): ?><tr><td colspan="9" class="text-center">No tickets found.</td></tr><?php endif; ?>
<?php foreach($tickets as $t): ?><tr>
<td><?=e($t['ticket_code'])?></td><td><?=e($t['title'])?></td><td><?=e($t['category'])?></td><td><?=e($t['reporter'])?></td>
<td><span class="badge badge-<?= $t['priority']==='Critical'?'danger':($t['priority']==='High'?'warning':'secondary') ?>"><?=e($t['priority'])?></span></td>
<td><?=e($t['status'])?></td><td><?=e($t['technician'] ?? 'Unassigned')?></td><td><?=e($t['created_at'])?></td><td><a class="btn btn-info btn-sm" href="view.php?id=<?=(int)$t['id']?>">Open</a></td>
</tr><?php endforeach; ?></tbody></table></div></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
