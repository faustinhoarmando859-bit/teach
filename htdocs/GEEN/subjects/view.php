```php
<?php

require_once "../config/database.php";

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET["id"]);

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

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    \n    <link rel="stylesheet" href="../css/style.css"><title>View Subject</title>

</head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

    <h1>Subject Details</h1>

    <p>
        <strong>Subject Name:</strong>
        <?php echo htmlspecialchars($subject["subject_name"]); ?>
    </p>

    <p>
        <strong>Subject Code:</strong>
        <?php echo htmlspecialchars($subject["subject_code"] ?? ""); ?>
    </p>

    <p>
        <strong>Created At:</strong>
        <?php echo htmlspecialchars($subject["created_at"]); ?>
    </p>

    <p>

        <a href="index.php" class="cancel">
            Back to Subjects
        </a>

        |

        <a href="edit.php?id=<?php echo $subject["id"]; ?>">
            Edit
        </a>

    </p>

</body>

</html>
```
 