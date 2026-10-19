<?php
require_once __DIR__ . '/../includes/auth.php';
require_role(['admin','technician']);
$success='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $asset=trim($_POST['asset_tag']??''); $name=trim($_POST['name']??''); $type=trim($_POST['equipment_type']??''); $location=trim($_POST['location']??'');
    $serial=trim($_POST['serial_number']??'') ?: null; $ip=trim($_POST['ip_address']??'') ?: null; $mac=trim($_POST['mac_address']??'') ?: null;
    $status=$_POST['status']??'Working';
    if($asset!==''&&$name!==''&&$type!==''&&$location!==''&&in_array($status,['Working','Needs Repair','Under Maintenance','Retired'],true)){
        try{$stmt=$pdo->prepare('INSERT INTO equipment(asset_tag,name,equipment_type,serial_number,ip_address,mac_address,location,status) VALUES(?,?,?,?,?,?,?,?)');$stmt->execute([$asset,$name,$type,$serial,$ip,$mac,$location,$status]);$success='Equipment added successfully.';}
        catch(PDOException $e){$success='Could not add equipment: check that the asset tag is unique.';}
    } else {$success='Please complete the required fields.';}
}
$items=$pdo->query('SELECT * FROM equipment ORDER BY created_at DESC')->fetchAll();
$pageTitle='Equipment Inventory';require __DIR__.'/../includes/header.php';
?>
<?php if($success): ?><div class="alert alert-info"><?=e($success)?></div><?php endif; ?>
<div class="card card-primary"><div class="card-header"><h3 class="card-title">Add equipment</h3></div><form method="post"><div class="card-body"><div class="row">
<div class="form-group col-md-3"><label>Asset tag *</label><input class="form-control" name="asset_tag" placeholder="PC-024" required></div>
<div class="form-group col-md-3"><label>Name *</label><input class="form-control" name="name" placeholder="Dell desktop" required></div>
<div class="form-group col-md-3"><label>Type *</label><input class="form-control" name="equipment_type" placeholder="Computer / Router" required></div>
<div class="form-group col-md-3"><label>Location *</label><input class="form-control" name="location" placeholder="Computer Lab 2" required></div>
<div class="form-group col-md-3"><label>Serial number</label><input class="form-control" name="serial_number"></div><div class="form-group col-md-3"><label>IP address</label><input class="form-control" name="ip_address"></div><div class="form-group col-md-3"><label>MAC address</label><input class="form-control" name="mac_address"></div>
<div class="form-group col-md-3"><label>Status</label><select class="form-control" name="status"><?php foreach(['Working','Needs Repair','Under Maintenance','Retired'] as $s): ?><option><?=$s?></option><?php endforeach; ?></select></div></div></div><div class="card-footer"><button class="btn btn-primary">Add Equipment</button></div></form></div>
<div class="card"><div class="card-header"><h3 class="card-title">Equipment list</h3></div><div class="card-body table-responsive"><table class="table table-bordered table-hover"><thead><tr><th>Asset tag</th><th>Name</th><th>Type</th><th>Serial</th><th>IP</th><th>MAC</th><th>Location</th><th>Status</th></tr></thead><tbody>
<?php if(!$items): ?><tr><td colspan="8" class="text-center">No equipment recorded yet.</td></tr><?php endif; ?>
<?php foreach($items as $it): ?><tr><td><?=e($it['asset_tag'])?></td><td><?=e($it['name'])?></td><td><?=e($it['equipment_type'])?></td><td><?=e($it['serial_number'])?></td><td><?=e($it['ip_address'])?></td><td><?=e($it['mac_address'])?></td><td><?=e($it['location'])?></td><td><?=e($it['status'])?></td></tr><?php endforeach; ?></tbody></table></div></div>
<?php require __DIR__.'/../includes/footer.php'; ?>
