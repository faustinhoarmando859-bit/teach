 ```php
<?php

require_once "../config/database.php";

$result = $conn->query("SELECT * FROM classes ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    \n    <link rel="stylesheet" href="../css/style.css"><title>Classes Management</title>

    </head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

    <h1>Classes Management</h1>


    <a href="add.php" class="button add-button">
            Add Class
        </a>

        <a href="../dashboard.php" class="back">
            Back to Dashboard
        </a>


    <div class="table-wrapper"><table class="data-table">

        <thead>

            <tr>

                <th>#</th>
                <th>Class Name</th>
                <th>Section</th>
                <th>Created At</th>
                <th>Actions</th>

            </tr>

        </thead>


        <tbody>

            <?php if ($result && $result->num_rows > 0): ?>

                <?php while ($class = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?php echo $class['id']; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($class['class_name']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($class['section'] ?? ''); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($class['created_at']); ?>
                        </td>

                        <td>

                            <a
                                href="view.php?id=<?php echo $class['id']; ?>"
                                class="button"
                            >
                                View
                            </a>

                            <a
                                href="edit.php?id=<?php echo $class['id']; ?>"
                                class="button"
                            >
                                Edit
                            </a>

                            <a
                                href="delete.php?id=<?php echo $class['id']; ?>"
                                class="button delete"
                                onclick="return confirm('Are you sure you want to delete this class?');"
                            >
                                Delete
                            </a>

                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>

                    <td colspan="5">
                        No classes found.
                    </td>

                </tr>

            <?php endif; ?>

        </tbody>

    </table></div>

</body>

</html>
```
