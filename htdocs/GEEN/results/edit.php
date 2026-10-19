```php
<?php

require_once "../config/database.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET["id"];

/* Get current result */
$stmt = $conn->prepare("
    SELECT student_id, subject_id, marks, exam_type
    FROM results
    WHERE id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Result not found.";
    exit();
}

$row = $result->fetch_assoc();


/* Update result */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $student_id = (int) $_POST["student_id"];
    $subject_id = (int) $_POST["subject_id"];
    $marks = (float) $_POST["marks"];
    $exam_type = trim($_POST["exam_type"]);

    /* Calculate grade */
    if ($marks >= 80) {
        $grade = "A";
    } elseif ($marks >= 70) {
        $grade = "B";
    } elseif ($marks >= 60) {
        $grade = "C";
    } elseif ($marks >= 50) {
        $grade = "D";
    } else {
        $grade = "F";
    }

    /* Validate marks */
    if ($marks < 0 || $marks > 100) {
        echo "Marks must be between 0 and 100.";
        exit();
    }

    /* Update database */
    $stmt = $conn->prepare("
        UPDATE results
        SET student_id = ?, subject_id = ?, marks = ?, grade = ?, exam_type = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "iidssi",
        $student_id,
        $subject_id,
        $marks,
        $grade,
        $exam_type,
        $id
    );

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Failed to update result.";
        exit();
    }
}


/* Get students */
$students = $conn->query("
    SELECT id, student_id, first_name, last_name
    FROM students
    ORDER BY first_name ASC
");


/* Get subjects */
$subjects = $conn->query("
    SELECT id, subject_name
    FROM subjects
    ORDER BY subject_name ASC
");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    \n    <link rel="stylesheet" href="../css/style.css"><title>Edit Result</title>

    </head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

    <h1>Edit Result</h1>

    <form method="POST" class="module-form">

        <label for="student_id">Student</label>

        <select name="student_id" id="student_id" required>

            <option value="">Select Student</option>

            <?php while ($student = $students->fetch_assoc()): ?>

                <option
                    value="<?php echo $student["id"]; ?>"
                    <?php
                    if ($student["id"] == $row["student_id"]) {
                        echo "selected";
                    }
                    ?>
                >

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


        <label for="subject_id">Subject</label>

        <select name="subject_id" id="subject_id" required>

            <option value="">Select Subject</option>

            <?php while ($subject = $subjects->fetch_assoc()): ?>

                <option
                    value="<?php echo $subject["id"]; ?>"
                    <?php
                    if ($subject["id"] == $row["subject_id"]) {
                        echo "selected";
                    }
                    ?>
                >

                    <?php echo htmlspecialchars($subject["subject_name"]); ?>

                </option>

            <?php endwhile; ?>

        </select>


        <label for="marks">Marks</label>

        <input
            type="number"
            name="marks"
            id="marks"
            min="0"
            max="100"
            step="0.01"
            value="<?php echo htmlspecialchars($row["marks"]); ?>"
            required
        >


        <label for="exam_type">Exam Type</label>

        <input
            type="text"
            name="exam_type"
            id="exam_type"
            value="<?php echo htmlspecialchars($row["exam_type"] ?? ""); ?>"
            placeholder="e.g. Midterm, Terminal, Annual"
        >


        <button type="submit" class="submit">Update Result</button>

        <a href="index.php" class="button">Cancel</a>

    </form>

</body>

</html>
```
