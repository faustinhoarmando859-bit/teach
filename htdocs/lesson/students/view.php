
<?php
require_once __DIR__ . "/../config/database.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    exit("Invalid student ID.");
}

$stmt = $pdo->prepare(
    "SELECT * FROM students WHERE id = ?"
);

$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    http_response_code(404);
    exit("Student not found. Please check the student ID.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student</title>
</head>
<body>

    <h1>Student Management System</h1>
    <h2>Student Details</h2>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>ID</th>
            <td><?= (int) $student["id"] ?></td>
        </tr>
        <tr>
            <th>Full Name</th>
            <td><?= htmlspecialchars($student["name"]) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= htmlspecialchars($student["email"]) ?></td>
        </tr>
        <tr>
            <th>Course</th>
            <td><?= htmlspecialchars($student["course"]) ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?= htmlspecialchars($student["status"]) ?></td>
        </tr>
        <tr>
            <th>Date Added</th>
            <td><?= htmlspecialchars($student["created_at"]) ?></td>
        </tr>
    </table>

    <p>
        <a href="read.php">Back to Students</a>
    </p>

    <p>
        <a href="update.php?id=<?= (int) $student["id"] ?>">Edit Student</a>
    </p>

</body>
</html>