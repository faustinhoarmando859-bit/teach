```php
<?php

require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $student_id = (int) $_POST["student_id"];
    $attendance_date = $_POST["attendance_date"];
    $status = trim($_POST["status"]);

    if ($student_id <= 0 || empty($attendance_date) || empty($status)) {
        echo "Please fill in all required fields.";
        exit();
    }

    $stmt = $conn->prepare("
        INSERT INTO attendance
        (student_id, attendance_date, status)
        VALUES (?, ?, ?)
    ");

    $stmt->bind_param(
        "iss",
        $student_id,
        $attendance_date,
        $status
    );

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Failed to add attendance.";
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

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    \n    <link rel="stylesheet" href="../css/style.css"><title>Add Attendance</title>

    </head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

    <h1>Add Attendance</h1>

    <form method="POST" class="module-form">

        <label for="student_id">
            Student
        </label>

        <select
            name="student_id"
            id="student_id"
            required
        >

            <option value="">
                Select Student
            </option>

            <?php while ($student = $students->fetch_assoc()): ?>

                <option value="<?php echo $student["id"]; ?>">

                    <?php
                    echo htmlspecialchars(
                        $student["student_id"] . " - " .
                        $student["first_name"] . " " .
                        $student["last_name"]
                    );
                    ?>

                </option>

            <?php endwhile; ?>

        </select>


        <label for="attendance_date">
            Attendance Date
        </label>

        <input
            type="date"
            name="attendance_date"
            id="attendance_date"
            required
        >


        <label for="status">
            Status
        </label>

        <select
            name="status"
            id="status"
            required
        >

            <option value="">
                Select Status
            </option>

            <option value="Present">
                Present
            </option>

            <option value="Absent">
                Absent
            </option>

            <option value="Late">
                Late
            </option>

        </select>


        <button type="submit" class="submit">
            Save Attendance
        </button>

        <a href="index.php" class="button">
            Cancel
        </a>

    </form>

</body>

</html>
```
