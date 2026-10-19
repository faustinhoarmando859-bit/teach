 ```php
<?php

require_once "../config/database.php";

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET["id"]);

$message = "";

/* Get subject information */

$stmt = $conn->prepare("SELECT * FROM subjects WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Subject not found.";
    exit();
}

$subject = $result->fetch_assoc();

$stmt->close();


/* Update subject */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $subject_name = trim($_POST["subject_name"]);
    $subject_code = trim($_POST["subject_code"]);

    if (empty($subject_name)) {

        $message = "Subject Name is required.";

    } else {

        $stmt = $conn->prepare(
            "UPDATE subjects
             SET subject_name = ?, subject_code = ?
             WHERE id = ?"
        );

        $stmt->bind_param("ssi", $subject_name, $subject_code, $id);

        if ($stmt->execute()) {

            header("Location: index.php");
            exit();

        } else {

            $message = "Failed to update subject.";

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

    \n    <link rel="stylesheet" href="../css/style.css"><title>Edit Subject</title>

</head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

    <h1>Edit Subject</h1>

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
                value="<?php echo htmlspecialchars($subject["subject_name"]); ?>"
                required
            >

        </p>

        <p>

            <label>Subject Code</label><br>

            <input
                type="text"
                name="subject_code"
                value="<?php echo htmlspecialchars($subject["subject_code"] ?? ""); ?>"
            >

        </p>

        <p>

            <button type="submit" class="submit">
                Update Subject
            </button>

            <a href="index.php" class="cancel">
                Cancel
            </a>

        </p>

    </form>

</body>

</html>
```
