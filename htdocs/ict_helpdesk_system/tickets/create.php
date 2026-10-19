<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$categories = $pdo->query('SELECT id,name FROM categories ORDER BY name')->fetchAll();
$equipment = $pdo->query('SELECT id,asset_tag,name,location FROM equipment WHERE status <> "Retired" ORDER BY asset_tag')->fetchAll();
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $title=trim($_POST['title']??''); $description=trim($_POST['description']??'');
    $location=trim($_POST['location']??''); $category=(int)($_POST['category_id']??0);
    $priority=$_POST['priority']??'Medium'; $equipmentId=($_POST['equipment_id']??'')!==''?(int)$_POST['equipment_id']:null;
    if($title===''||$description===''||$location===''||!in_array($priority,['Low','Medium','High','Critical'],true)){
        $error='Complete all required fields.';
    } else {
        $code='ICT-'.date('ymd').'-'.strtoupper(bin2hex(random_bytes(3)));
        $stmt=$pdo->prepare("INSERT INTO tickets(ticket_code,user_id,category_id,equipment_id,title,description,location,priority) VALUES(?,?,?,?,?,?,?,?)");
        $stmt->execute([$code,current_user()['id'],$category,$equipmentId,$title,$description,$location,$priority]);
        header('Location: view.php?id='.$pdo->lastInsertId()); exit;
    }
}
$pageTitle='Report a Problem'; require __DIR__.'/../includes/header.php';
?>
<div class="card card-primary"><div class="card-header"><h3 class="card-title">New helpdesk ticket</h3></div><form method="post"><div class="card-body">
<?php if($error): ?><div class="alert alert-danger"><?=e($error)?></div><?php endif; ?>
<div class="form-group"><label>Problem title *</label><input class="form-control" name="title" required maxlength="160" value="<?=e($_POST['title']??'')?>"></div>
<div class="form-group"><label>Category *</label><select class="form-control" name="category_id" required><option value="">Choose category</option><?php foreach($categories as $c): ?><option value="<?=$c['id']?>" <?=((int)($_POST['category_id']??0)===$c['id'])?'selected':''?>><?=e($c['name'])?></option><?php endforeach; ?></select></div>
<div class="form-group"><label>Related equipment (optional)</label><select class="form-control" name="equipment_id"><option value="">Not linked to equipment</option><?php foreach($equipment as $eq): ?><option value="<?=$eq['id']?>"><?=e($eq['asset_tag'].' - '.$eq['name'].' ('.$eq['location'].')')?></option><?php endforeach; ?></select></div>
<div class="form-group"><label>Location *</label><input class="form-control" name="location" placeholder="e.g. Computer Lab 2" required value="<?=e($_POST['location']??'')?>"></div>
<div class="form-group"><label>Priority</label><select class="form-control" name="priority"><?php foreach(['Low','Medium','High','Critical'] as $p): ?><option <?=$p===($_POST['priority']??'Medium')?'selected':''?>><?=$p?></option><?php endforeach; ?></select></div>
<div class="form-group"><label>Description *</label><textarea class="form-control" name="description" rows="5" required><?=e($_POST['description']??'')?></textarea><small class="form-text text-muted">Describe what happened and any error message shown.</small></div>
</div><div class="card-footer"><button class="btn btn-primary">Submit Ticket</button> <a class="btn btn-default" href="index.php">Cancel</a></div></form></div>
<?php require __DIR__.'/../includes/footer.php'; ?>
