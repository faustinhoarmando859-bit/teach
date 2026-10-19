```php id="v1d6aq"
<?php

require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $student_id = (int) $_POST["student_id"];
    $amount = (float) $_POST["amount"];
    $payment_date = $_POST["payment_date"];
    $payment_method = trim($_POST["payment_method"]);
    $description = trim($_POST["description"]);

    if (
        $student_id <= 0 ||
        $amount <= 0 ||
        empty($payment_date)
    ) {
        echo "Please fill in all required fields.";
        exit();
    }

    $stmt = $conn->prepare("
        INSERT INTO fees
        (student_id, amount, payment_date, payment_method, description)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "idsss",
        $student_id,
        $amount,
        $payment_date,
        $payment_method,
        $description
    );

    if ($stmt->execute()) {

        header("Location: index.php");
        exit();

    } else {

        echo "Failed to add fee record.";
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

    <title>Add Fee</title>

    </head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

    <h1>Add Fee</h1>

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


        <label for="amount">
            Amount
        </label>

        <input
            type="number"
            name="amount"
            id="amount"
            min="0.01"
            step="0.01"
            placeholder="Enter amount"
            required
        >


        <label for="payment_date">
            Payment Date
        </label>

        <input
            type="date"
            name="payment_date"
            id="payment_date"
            required
        >


        <label for="payment_method">
            Payment Method
        </label>

        <select
            name="payment_method"
            id="payment_method"
        >

            <option value="">
                Select Payment Method
            </option>

            <option value="Cash">
                Cash
            </option>

            <option value="Bank">
                Bank
            </option>

            <option value="Mobile Money">
                Mobile Money
            </option>

            <option value="Cheque">
                Cheque
            </option>

        </select>


        <label for="description">
            Description
        </label>

        <textarea
            name="description"
            id="description"
            placeholder="Enter description (optional)"
        ></textarea>


        <button type="submit" class="submit">
            Save Fee
        </button>

        <a href="index.php" class="button">
            Cancel
        </a>

    </form>

</body>

</html>
```
