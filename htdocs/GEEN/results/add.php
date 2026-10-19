```php
<?php

require_once "../config/database.php";

$message = "";

/* Get students */

$students = $conn->query(
    "SELECT id, student_id, first_name, last_name
     FROM students
     ORDER BY first_name ASC"
);

/* Get subjects */

$subjects = $conn->query(
    "SELECT id, subject_name
     FROM subjects
     ORDER BY subject_name ASC"
);


/* Save result */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_id = intval($_POST["student_id"]);
    $subject_id = intval($_POST["subject_id"]);
    $marks = floatval($_POST["marks"]);
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


    /* Check marks */

    if ($marks < 0 || $marks > 100) {

        $message = "Marks must be between 0 and 100.";

    } elseif ($student_id <= 0) {

        $message = "Please select a student.";

    } elseif ($subject_id <= 0) {

        $message = "Please select a subject.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO results
            (student_id, subject_id, marks, grade, exam_type)
            VALUES (?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "iidss",
            $student_id,
            $subject_id,
            $marks,
            $grade,
            $exam_type
        );

        if ($stmt->execute()) {

            header("Location: index.php");
            exit();

        } else {

            $message = "Failed to add result.";

        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    \n    <link rel="stylesheet" href="../css/style.css"><title>Add Result</title>

</head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

    <h1>Add Result</h1>

    <?php if (!empty($message)): ?>

        <p>
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php endif; ?>


    <form method="POST" class="module-form">

        <p>

            <label>Student</label><br>

            <select name="student_id" required>

                <option value="">
                    Select Student
                </option>

                <?php while ($student = $students->fetch_assoc()): ?>

                    <option value="<?php echo $student["id"]; ?>">

                        <?php echo htmlspecialchars(
                            $student["student_id"] . " - " .
                            $student["first_name"] . " " .
                            $student["last_name"]
                        ); ?>

                    </option>

                <?php endwhile; ?>

            </select>

        </p>


        <p>

            <label>Subject</label><br>

            <select name="subject_id" required>

                <option value="">
                    Select Subject
                </option>

                <?php while ($subject = $subjects->fetch_assoc()): ?>

                    <option value="<?php echo $subject["id"]; ?>">

                        <?php echo htmlspecialchars(
                            $subject["subject_name"]
                        ); ?>

                    </option>

                <?php endwhile; ?>

            </select>

        </p>


        <p>

            <label>Marks</label><br>

            <input
                type="number"
                name="marks"
                min="0"
                max="100"
                step="0.01"
                required
            >

        </p>


        <p>

            <label>Exam Type</label><br>

            <input
                type="text"
                name="exam_type"
                placeholder="Example: Midterm"
            >

        </p>


        <p>

            <button type="submit" class="submit">
                Add Result
            </button>

            <a href="index.php" class="cancel">
                Cancel
            </a>

        </p>

    </form>

</body>

</html>
```
 