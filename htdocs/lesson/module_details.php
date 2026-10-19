<?php
require __DIR__ . "/config/database.php";
require __DIR__ . "/include/header.php";

if (!isset($_GET['id'])) {
    die("Module ID is missing.");
}
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM MODULE WHERE id = ?");
$stmt->execute([$id]);
$module = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$module) {
    die("Module not found.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Module Details</title>
</head>
<body>
<h2>Module Details</h2>
<p>
    <strong>Module ID:</strong>
    <?php echo htmlspecialchars($module['id']); ?>
</p>
<p>
    <strong>Module name:</strong>
    <?php echo htmlspecialchars($module['module_name']); ?>
</p>
<p>
    <strong>Module code:</strong>
    <?php echo htmlspecialchars($module['module_code']); ?>
</p>
<p>
    <strong>Department:</strong>
    <?php echo htmlspecialchars($module['department']); ?>
</p>
<a href="module.php">Back to Modules</a>
</body>
</html>

<?php

$sql = "SELECT department, COUNT(*) AS total
        FROM MODULE
        GROUP BY department";
$stmt = $pdo->query($sql);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$departments = [];
$totals = [];
foreach ($result as $row) {
    $departments[] = $row['department'];
    $totals[] = (int)$row['total'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Module Dashboard</title>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<h2>Module Dashboard</h2>
<h3>Modules by Department</h3>
<div style="width: 700px; max-width: 100%;">
    <canvas id="moduleChart"></canvas>
</div>
<script>
const departments = <?php echo json_encode($departments); ?>;
const totals = <?php echo json_encode($totals); ?>;
new Chart(document.getElementById('moduleChart'), {
    type: 'bar',
    data: {
        labels: departments,
        datasets: [{
            label: 'Number of Modules',
            data: totals,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        }
    }
});
</script>
<br>
<a href="module.php">View All Modules</a>
</body>
</html> 

<?php require __DIR__ . "/include/footer.php"; ?>

<!-- :::
**Kumbuka:** Kama unafanya kazi bila internet, tutahitaji kutumia Chart.js iliyopo kwenye `plugins` folder yako badala ya CDN. Pia, kwa sasa pages hizi zina HTML ya kawaida; ili zitumie AdminLTE kikamilifu, tutahitaji kuingiza layout na assets za project yako.
--- -->
<!-- ## STEP 5: Tufanye kazi kwa usahihi
Kabla hujanakili code zote, nataka kuhakikisha hazitagongana na project yako iliyopo.
**Nitume screenshot moja ya `module.php` yako ya sasa, pamoja na sehemu ya juu ya code yake.**
Nitairekebisha kulingana na muundo wako wa AdminLTE badala ya kukufanya uanze upya. -->