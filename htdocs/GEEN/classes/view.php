 ```php
<?php

require_once "../config/database.php";

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET["id"]);

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

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    \n    <link rel="stylesheet" href="../css/style.css"><title>View Class</title>

</head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

    <h1>Class Details</h1>

    <p>
        <strong>Class Name:</strong>
        <?php echo htmlspecialchars($class["class_name"]); ?>
    </p>

    <p>
        <strong>Section:</strong>
        <?php echo htmlspecialchars($class["section"] ?? ""); ?>
    </p>

    <p>
        <strong>Created At:</strong>
        <?php echo htmlspecialchars($class["created_at"]); ?>
    </p>

    <p>

        <a href="index.php" class="cancel">
            Back to Classes
        </a>

        |

        <a href="edit.php?id=<?php echo $class["id"]; ?>">
            Edit
        </a>

    </p>

</body>

</html>
```
