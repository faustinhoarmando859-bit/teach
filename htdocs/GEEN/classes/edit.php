 ```php
<?php

require_once "../config/database.php";

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET["id"]);

$message = "";

/* Get class information */

$stmt = $conn->prepare("SELECT * FROM classes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Class not found.";
    exit();
}

$class = $result->fetch_assoc();

$stmt->close();


/* Update class */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $class_name = trim($_POST["class_name"]);
    $section = trim($_POST["section"]);

    if (empty($class_name)) {

        $message = "Class Name is required.";

    } else {

        $stmt = $conn->prepare(
            "UPDATE classes SET class_name = ?, section = ? WHERE id = ?"
        );

        $stmt->bind_param("ssi", $class_name, $section, $id);

        if ($stmt->execute()) {

            header("Location: index.php");
            exit();

        } else {

            $message = "Failed to update class.";

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

    \n    <link rel="stylesheet" href="../css/style.css"><title>Edit Class</title>

</head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

    <h1>Edit Class</h1>

    <?php if (!empty($message)): ?>

        <p>
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php endif; ?>

    <form method="POST" class="module-form">

        <p>

            <label>Class Name</label><br>

            <input
                type="text"
                name="class_name"
                value="<?php echo htmlspecialchars($class["class_name"]); ?>"
                required
            >

        </p>

        <p>

            <label>Section</label><br>

            <input
                type="text"
                name="section"
                value="<?php echo htmlspecialchars($class["section"] ?? ""); ?>"
            >

        </p>

        <p>

            <button type="submit" class="submit">
                Update Class
```
