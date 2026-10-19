 ```php
<?php

require_once "../config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $class_name = trim($_POST["class_name"]);
    $section = trim($_POST["section"]);

    if (empty($class_name)) {

        $message = "Class Name is required.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO classes (class_name, section) VALUES (?, ?)"
        );

        $stmt->bind_param("ss", $class_name, $section);

        if ($stmt->execute()) {

            header("Location: index.php");
            exit();

        } else {

            $message = "Failed to add class.";

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

    \n    <link rel="stylesheet" href="../css/style.css"><title>Add Class</title>

</head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

    <h1>Add Class</h1>

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
                required
            >
        </p>

        <p>
            <label>Section</label><br>

            <input
                type="text"
                name="section"
            >
        </p>

        <p>

            <button type="submit" class="submit">
                Add Class
            </button>

            <a href="index.php" class="cancel">
                Cancel
            </a>

        </p>

    </form>

</body>

</html>
```
