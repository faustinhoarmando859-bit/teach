```php id="r5k3qm"
<?php

require_once "../config/database.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET["id"];

$sql = "
    SELECT
        fees.id,
        fees.amount,
        fees.payment_date,
        fees.payment_method,
        fees.description,
        fees.created_at,
        students.student_id,
        students.first_name,
        students.last_name
    FROM fees
    INNER JOIN students
        ON fees.student_id = students.id
    WHERE fees.id = ?
";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Fee record not found.";
    exit();
}

$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>View Fee</title>

    </head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

    <h1>View Fee</h1>

    <table class="details">

        <tr>

            <th>Student ID</th>

            <td>
                <?php
                echo htmlspecialchars($row["student_id"]);
                ?>
```
