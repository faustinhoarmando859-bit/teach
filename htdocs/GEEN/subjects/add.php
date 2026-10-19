 ```php
<?php

require_once "../config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $subject_name = trim($_POST["subject_name"]);
    $subject_code = trim($_POST["subject_code"]);

    if (empty($subject_name)) {

        $message = "Subject Name is required.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO subjects (subject_name, subject_code) VALUES (?, ?)"
        );

        $stmt->bind_param("ss", $subject_name, $subject_code);

        if ($stmt->execute()) {

            header("Location: index.php");
            exit();

        } else {

            $message = "Failed to add subject.";

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

    \n    <link rel="stylesheet" href="../css/style.css"><title>Add Subject</title>

</head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

    <h1>Add Subject</h1>

    <?php if (!empty($message)): ?>

        <p>
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php endif; ?>

    <form method="POST" class="module-form">

        <p>

            <label>Subject Name</label><br>

            <input
                type="text"
                name="subject_name"
                required
            >

        </p>

        <p>

            <label>Subject Code</label><br>

            <input
                type="text"
                name="subject_code"
            >

        </p>

        <p>

            <button type="submit" class="submit">
                Add Subject
            </button>

            <a href="index.php" class="cancel">
                Cancel
            </a>

        </p>

    </form>

</body>

</html>
```
