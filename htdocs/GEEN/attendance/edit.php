```php
<?php

require_once "../config/database.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET["id"];


/* Get current attendance record */

$stmt = $conn->prepare("
    SELECT student_id, attendance_date, status
    FROM attendance
    WHERE id = ?
");

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Attendance record not found.";
    exit();
}

$row = $result->fetch_assoc();


/* Update attendance */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $student_id = (int) $_POST["student_id"];
    $attendance_date = $_POST["attendance_date"];
    $status = trim($_POST["status"]);

    if (
        $student_id <= 0 ||
        empty($attendance_date) ||
        empty($status)
    ) {
        echo "Please fill in all required fields.";
        exit();
    }

    $stmt = $conn->prepare("
        UPDATE attendance
        SET student_id = ?,
            attendance_date = ?,
            status = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "issi",
        $student_id,
        $attendance_date,
        $status,
        $id
    );

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Failed to update attendance.";
        exit();
    }
}


/* Get students */

$students = $conn->query("
    SELECT id, student_id, first_name, last_name
    FROM students
    ORDER BY first_name ASC
");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Attendance</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            width: 500px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        button,
        .button {
            padding: 8px 12px;
            margin-top: 20px;
            margin-right: 5px;
            border: 1px solid #333;
            background: white;
```
