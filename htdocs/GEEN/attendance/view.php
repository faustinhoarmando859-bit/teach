```php
<?php

require_once "../config/database.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET["id"];

$sql = "
    SELECT
        attendance.id,
        attendance.attendance_date,
        attendance.status,
        attendance.created_at,
        students.student_id,
        students.first_name,
        students.last_name
    FROM attendance
    INNER JOIN students
        ON attendance.student_id = students.id
    WHERE attendance.id = ?
";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Attendance record not found.";
    exit();
}

$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    \n    <link rel="stylesheet" href="../css/style.css"><title>View Attendance</title>

    </head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

    <h1>View Attendance</h1>

    <table class="details">

        <tr>
            <th>Student ID</th>

            <td>
                <?php
                echo htmlspecialchars($row["student_id"]);
                ?>
            </td>
        </tr>

        <tr>
            <th>Student Name</th>

            <td>
                <?php
                echo htmlspecialchars(
                    $row["first_name"] . " " . $row["last_name"]
                );
                ?>
            </td>
        </tr>

        <tr>
            <th>Attendance Date</th>

            <td>
                <?php
                echo htmlspecialchars(
                    $row["attendance_date"]
                );
                ?>
            </td>
        </tr>

        <tr>
            <th>Status</th>

            <td>
                <?php
                echo htmlspecialchars(
                    $row["status"]
                );
                ?>
            </td>
        </tr>

        <tr>
            <th>Created At</th>

            <td>
                <?php
                echo htmlspecialchars(
                    $row["created_at"]
                );
                ?>
            </td>
        </tr>

    </table></div>

    <a href="index.php" class="button">
        Back to Attendance
    </a>

    <a
        href="edit.php?id=<?php echo $row["id"]; ?>"
        class="button"
    >
        Edit Attendance
    </a>

</body>

</html>
```
