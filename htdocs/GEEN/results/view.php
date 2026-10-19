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
        results.id,
        results.marks,
        results.grade,
        results.exam_type,
        results.created_at,
        students.student_id,
        students.first_name,
        students.last_name,
        subjects.subject_name
    FROM results
    INNER JOIN students
        ON results.student_id = students.id
    INNER JOIN subjects
        ON results.subject_id = subjects.id
    WHERE results.id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Result not found.";
    exit();
}

$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    \n    <link rel="stylesheet" href="../css/style.css"><title>View Result</title>

    </head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

    <h1>View Result</h1>

    <table class="details">

        <tr>
            <th>Student ID</th>
            <td>
                <?php echo htmlspecialchars($row["student_id"]); ?>
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
            <th>Subject</th>
            <td>
                <?php echo htmlspecialchars($row["subject_name"]); ?>
            </td>
        </tr>

        <tr>
            <th>Marks</th>
            <td>
                <?php echo htmlspecialchars($row["marks"]); ?>
            </td>
        </tr>

        <tr>
            <th>Grade</th>
            <td>
                <?php echo htmlspecialchars($row["grade"] ?? ""); ?>
            </td>
        </tr>

        <tr>
            <th>Exam Type</th>
            <td>
                <?php echo htmlspecialchars($row["exam_type"] ?? ""); ?>
            </td>
        </tr>

        <tr>
            <th>Created At</th>
            <td>
                <?php echo htmlspecialchars($row["created_at"]); ?>
            </td>
        </tr>

    </table></div>

    <a href="index.php" class="button">Back to Results</a>

    <a href="edit.php?id=<?php echo $row["id"]; ?>" class="button">
        Edit Result
    </a>

</body>

</html>
```
 