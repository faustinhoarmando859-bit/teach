```php id="4wq7nx"
<?php

require_once "../config/database.php";

$sql = "
    SELECT
        fees.id,
        fees.amount,
        fees.payment_date,
        fees.payment_method,
        fees.description,
        fees.created_at,
        students.student_id,
        students.first_name,
        students.last_name
    FROM fees
    INNER JOIN students
        ON fees.student_id = students.id
    ORDER BY fees.payment_date DESC, fees.id DESC
";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Fees Management</title>

    </head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

    <h1>Fees Management</h1>

    <a href="add.php" class="button add-button">
            Add Fee
        </a>

        <a href="../dashboard.php" class="back">
            Back to Dashboard
        </a>

    <div class="table-wrapper"><table class="data-table">

        <thead>

            <tr>
                <th>#</th>
                <th>Student</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Payment Method</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>

        </thead>

        <tbody>

            <?php if ($result && $result->num_rows > 0): ?>

                <?php while ($row = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?php echo $row["id"]; ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $row["student_id"] . " - " .
                                $row["first_name"] . " " .
                                $row["last_name"]
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $row["amount"]
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $row["payment_date"]
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $row["payment_method"] ?? ""
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $row["description"] ?? ""
                            );
                            ?>
                        </td>

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $row["created_at"]
                            );
                            ?>
                        </td>

                        <td>

                            <a
                                href="view.php?id=<?php echo $row["id"]; ?>"
                                class="button"
                            >
                                View
                            </a>

                            <a
                                href="edit.php?id=<?php echo $row["id"]; ?>"
                                class="button"
                            >
                                Edit
                            </a>

                            <a
                                href="delete.php?id=<?php echo $row["id"]; ?>"
                                class="button delete"
                                onclick="return confirm('Are you sure you want to delete this fee record?');"
                            >
                                Delete
                            </a>

                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>

                    <td colspan="8">
                        No fee records found.
                    </td>

                </tr>

            <?php endif; ?>

        </tbody>

    </table></div>

</body>

</html>
```
