```php id="9c2m4v"
<?php

require_once "../config/database.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET["id"];


/* Get current fee record */

$stmt = $conn->prepare("
    SELECT student_id, amount, payment_date, payment_method, description
    FROM fees
    WHERE id = ?
");

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Fee record not found.";
    exit();
}

$row = $result->fetch_assoc();


/* Update fee */

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
        UPDATE fees
        SET student_id = ?,
            amount = ?,
            payment_date = ?,
            payment_method = ?,
            description = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "idsssi",
        $student_id,
        $amount,
        $payment_date,
        $payment_method,
        $description,
        $id
    );

    if ($stmt->execute()) {

        header("Location: index.php");
        exit();

    } else {

        echo "Failed to update fee record.";
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

    <title>Edit Fee</title>

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
        select,
        textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
            resize: vertical;
        }

        button,
        .button {
            padding: 8px 12px;
            margin-top: 20px;
            margin-right: 5px;
            border: 1px solid #333;
            background: white;
            color: black;
            text-decoration: non
```
