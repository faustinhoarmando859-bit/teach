<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
$user = current_user();
$where = ticket_visible_sql();
$total = (int)$pdo->query("SELECT COUNT(*) FROM tickets t WHERE $where")->fetchColumn();
$pending = (int)$pdo->query("SELECT COUNT(*) FROM tickets t WHERE $where AND t.status='Pending'")->fetchColumn();
$progress = (int)$pdo->query("SELECT COUNT(*) FROM tickets t WHERE $where AND t.status='In Progress'")->fetchColumn();
$resolved = (int)$pdo->query("SELECT COUNT(*) FROM tickets t WHERE $where AND t.status IN ('Resolved','Closed')")->fetchColumn();
$pageTitle = 'Dashboard';
require __DIR__ . '/includes/header.php';
?>
<div class="row">
<?php foreach ([['Total Tickets',$total,'fa-ticket-alt','info'],['Pending',$pending,'fa-clock','warning'],['In Progress',$progress,'fa-tools','primary'],['Resolved / Closed',$resolved,'fa-check-circle','success']] as $card): ?>
<div class="col-lg-3 col-6"><div class="small-box bg-<?=$card[3]?>"><div class="inner"><h3><?=$card[1]?></h3><p><?=$card[0]?></p></div><div class="icon"><i class="fas <?=$card[2]?>"></i></div><a href="tickets/index.php" class="small-box-footer">View tickets <i class="fas fa-arrow-circle-right"></i></a></div></div>
<?php endforeach; ?>
</div>
<div class="row"><div class="col-md-8"><div class="card"><div class="card-header"><h3 class="card-title">Welcome to ICT Helpdesk</h3></div><div class="card-body">
<p>Hello, <b><?=e($user['full_name'])?></b>. Use this system to report ICT issues and track progress.</p>
<?php if($user['role']==='user'): ?><a class="btn btn-primary" href="tickets/create.php"><i class="fas fa-plus"></i> Report a Problem</a><?php endif; ?>
<a class="btn btn-outline-secondary" href="tickets/index.php">View Tickets</a>
<?php if(is_staff()): ?><a class="btn btn-outline-info" href="equipment/index.php">Manage Equipment</a><?php endif; ?>
</div></div></div><div class="col-md-4"><div class="card card-primary card-outline"><div class="card-header"><h3 class="card-title">System workflow</h3></div><div class="card-body"><ol><li>User reports a problem.</li><li>Ticket is stored in MySQL.</li><li>Staff assign and investigate.</li><li>Technician records resolution.</li></ol></div></div></div></div>
<?php require __DIR__ . '/includes/footer.php'; ?>
