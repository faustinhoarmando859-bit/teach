 ```php
<?php

require_once "../config/database.php";

$result = $conn->query("SELECT * FROM teachers ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    \n    <link rel="stylesheet" href="../css/style.css"><title>Teachers Management</title>

    </head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

    <h1>Teachers Management</h1>


    <a href="add.php" class="button add-button">
            Add Teacher
        </a>

        <a href="../dashboard.php" class="back">
            Back to Dashboard
        </a>


    <div class="table-wrapper"><table class="data-table">

        <thead>

            <tr>

                <th>#</th>
                <th>Teacher ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Actions</th>

            </tr>

        </thead>


        <tbody>

            <?php if ($result && $result->num_rows > 0): ?>

                <?php while ($teacher = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?php echo $teacher['id']; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($teacher['teacher_id']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($teacher['first_name']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($teacher['last_name']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($teacher['gender']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($teacher['phone'] ?? ''); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($teacher['email'] ?? ''); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($teacher['subject'] ?? ''); ?>
                        </td>

                        <td>

                            <a
                                href="view.php?id=<?php echo $teacher['id']; ?>"
                                class="button"
                            >
                                View
                            </a>

                            <a
                                href="edit.php?id=<?php echo $teacher['id']; ?>"
                                class="button"
                            >
                                Edit
                            </a>

                            <a
                                href="delete.php?id=<?php echo $teacher['id']; ?>"
                                class="button delete"
                                onclick="return confirm('Are you sure you want to delete this teacher?');"
                            >
                                Delete
                            </a>

                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>

                    <td colspan="9">
                        No teachers found.
                    </td>

                </tr>

            <?php endif; ?>

        </tbody>

    </table></div>

</body>

</html>
```
