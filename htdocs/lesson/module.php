<?php
require __DIR__ . "/config/database.php";
require __DIR__ . "/include/header.php";

$department = "";
if (isset($_GET['department'])) {
    $department = $_GET['department'];
}
    $stmt = $pdo->query("SELECT DISTINCT department FROM MODULE ORDER BY department");
    $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($department != "") {
    $stmt = $pdo->prepare("SELECT * FROM MODULE WHERE department = ?");
    $stmt->execute([$department]);
    $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->query("SELECT * FROM MODULE");
    $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Module management</title>
</head>
<body>
<h2>Module management</h2>
<form method="GET">
    <label>Select department:</label>
    <select name="department">
        <option value="">All departments</option>
        <?php foreach ($departments as $row): ?>
            <option value="<?php echo htmlspecialchars($row['department']); ?>"
                <?php echo ($department === $row['department']) ? 'selected': '';?>>
                <?php echo htmlspecialchars($row['department']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Filter</button>
</form>
<br>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Module ID</th>
        <th>Module Name</th>
        <th>Module Code</th>
        <th>Department</th>
        <th>Action</th>
    </tr>
    <?php foreach($modules as $row) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['module_name']); ?></td>
            <td><?php echo htmlspecialchars($row['module_code']); ?></td>
            <td><?php echo htmlspecialchars($row['department']); ?></td>
            <td>
                <button><a href="module_details.php?id=<?php echo urlencode($row['id']); ?>">View Details</a></button>
            </td>
        </tr>
    <?php } ?>
</table>
</body>
</html>
