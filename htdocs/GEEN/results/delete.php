```php
<?php

require_once "../config/database.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET["id"];

/* Delete result */
$stmt = $conn->prepare("
    DELETE FROM results
    WHERE id = ?
");

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php");
    exit();
} else {
    echo "Failed to delete result.";
}

?>
```
