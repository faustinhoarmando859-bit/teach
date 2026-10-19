<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$id=(int)($_GET['id']??0); $user=current_user();
$stmt=$pdo->prepare("SELECT t.*,u.full_name reporter,u.email reporter_email,c.name category,eq.asset_tag,eq.name equipment_name,tech.full_name technician
FROM tickets t JOIN users u ON u.id=t.user_id JOIN categories c ON c.id=t.category_id
LEFT JOIN equipment eq ON eq.id=t.equipment_id LEFT JOIN users tech ON tech.id=t.technician_id WHERE t.id=?");
$stmt->execute([$id]); $t=$stmt->fetch();
if(!$t || ($user['role']==='user' && (int)$t['user_id']!==(int)$user['id']) || ($user['role']==='technician' && $t['technician_id'] && (int)$t['technician_id']!==(int)$user['id'])) { http_response_code(404); exit('Ticket not found or access denied.'); }
$error='';
if($_SERVER['REQUEST_METHOD']==='POST' && is_staff()){
    $status=$_POST['status']??$t['status']; $notes=trim($_POST['resolution_notes']??'');
    $techId=($_POST['technician_id']??'')!==''?(int)$_POST['technician_id']:null;
    $allowed=['Pending','Assigned','In Progress','Resolved','Closed'];
    if(!in_array($status,$allowed,true)){ $error='Invalid status.'; }
    else {
        if($user['role']==='technician') $techId=(int)$user['id'];
        $stmt=$pdo->prepare('UPDATE tickets SET status=?, technician_id=?, resolution_notes=? WHERE id=?');
        $stmt->execute([$status,$techId,$notes,$id]);
        header('Location: view.php?id='.$id); exit;
    }
}
$techs=$pdo->query("SELECT id,full_name FROM users WHERE role='technician' ORDER BY full_name")->fetchAll();
$pageTitle='Ticket Details'; require __DIR__.'/../includes/header.php';
?>
<div class="row"><div class="col-md-8"><div class="card card-primary"><div class="card-header"><h3 class="card-title"><?=e($t['ticket_code'])?> — <?=e($t['title'])?></h3></div><div class="card-body">
<?php if($error): ?><div class="alert alert-danger"><?=e($error)?></div><?php endif; ?>
<dl class="row"><dt class="col-sm-3">Status</dt><dd class="col-sm-9"><?=e($t['status'])?></dd><dt class="col-sm-3">Priority</dt><dd class="col-sm-9"><?=e($t['priority'])?></dd><dt class="col-sm-3">Category</dt><dd class="col-sm-9"><?=e($t['category'])?></dd><dt class="col-sm-3">Reporter</dt><dd class="col-sm-9"><?=e($t['reporter'])?> (<?=e($t['reporter_email'])?>)</dd><dt class="col-sm-3">Location</dt><dd class="col-sm-9"><?=e($t['location'])?></dd><dt class="col-sm-3">Equipment</dt><dd class="col-sm-9"><?=e($t['asset_tag'] ? $t['asset_tag'].' - '.$t['equipment_name'] : 'Not specified')?></dd><dt class="col-sm-3">Technician</dt><dd class="col-sm-9"><?=e($t['technician']??'Unassigned')?></dd><dt class="col-sm-3">Description</dt><dd class="col-sm-9"><?=nl2br(e($t['description']))?></dd><dt class="col-sm-3">Resolution</dt><dd class="col-sm-9"><?=nl2br(e($t['resolution_notes']??'Not resolved yet'))?></dd><dt class="col-sm-3">Created</dt><dd class="col-sm-9"><?=e($t['created_at'])?></dd></dl>
<a href="index.php" class="btn btn-default">Back to tickets</a></div></div></div>
<?php if(is_staff()): ?><div class="col-md-4"><div class="card card-warning"><div class="card-header"><h3 class="card-title">Update ticket</h3></div><form method="post"><div class="card-body">
<div class="form-group"><label>Status</label><select class="form-control" name="status"><?php foreach(['Pending','Assigned','In Progress','Resolved','Closed'] as $s): ?><option <?=$s===$t['status']?'selected':''?>><?=$s?></option><?php endforeach; ?></select></div>
<?php if($user['role']==='admin'): ?><div class="form-group"><label>Assign technician</label><select class="form-control" name="technician_id"><option value="">Unassigned</option><?php foreach($techs as $tech): ?><option value="<?=$tech['id']?>" <?=((int)$t['technician_id']===(int)$tech['id'])?'selected':''?>><?=e($tech['full_name'])?></option><?php endforeach; ?></select></div><?php endif; ?>
<div class="form-group"><label>Resolution / notes</label><textarea class="form-control" name="resolution_notes" rows="5"><?=e($t['resolution_notes']??'')?></textarea></div>
</div><div class="card-footer"><button class="btn btn-warning">Save Update</button></div></form></div></div><?php endif; ?>
</div>
<?php require __DIR__.'/../includes/footer.php'; ?>
