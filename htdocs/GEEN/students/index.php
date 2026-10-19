 ```php
<?php

require_once "../config/database.php";

$result = $conn->query("SELECT * FROM students ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    \n    <link rel="stylesheet" href="../css/style.css"><title>Students Management</title>

    </head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

    <h1>Students Management</h1>

    <a href="add.php" class="add-button">
            Add Student
        </a>

        <a href="../dashboard.php" class="back">
            Back to Dashboard
        </a>


    <div class="table-wrapper"><table class="data-table">

        <thead>

            <tr>

                <th>#</th>

                <th>Student ID</th>

                <th>First Name</th>

                <th>Last Name</th>

                <th>Gender</th>

                <th>Date of Birth</th>

                <th>Class</th>

                <th>Phone</th>

                <th>Actions</th>

            </tr>

        </thead>


        <tbody>

            <?php if ($result && $result->num_rows > 0): ?>

                <?php while ($student = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?php echo $student['id']; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($student['student_id']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($student['first_name']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($student['last_name']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($student['gender']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($student['date_of_birth'] ?? ''); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($student['class'] ?? ''); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($student['phone'] ?? ''); ?>
                        </td>

                        <td>

                            <a
                                href="view.php?id=<?php echo $student['id']; ?>"
                                class="button"
                            >
                                View
                            </a>

                            <a
                                href="edit.php?id=<?php echo $student['id']; ?>"
                                class="button"
                            >
                                Edit
                            </a>

                            <a
                                href="delete.php?id=<?php echo $student['id']; ?>"
                                class="button delete"
                                onclick="return confirm('Are you sure you want to delete this student?');"
                            >
                                Delete
                            </a>

                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>

                    <td colspan="9">
                        No students found.
                    </td>

                </tr>

            <?php endif; ?>

        </tbody>

    </table></div>

</body>

</html>
```
