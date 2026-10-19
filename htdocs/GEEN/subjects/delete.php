```php
<?php

require_once "../config/database.php";

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET["id"]);

$stmt = $conn->prepare("DELETE FROM subjects WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    header("Location: index.php");
    exit();

} else {

    echo "Failed to delete subject.";

}

$stmt->close();

?>
```
 