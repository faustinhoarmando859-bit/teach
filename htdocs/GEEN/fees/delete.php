```php id="6xj8pf"
<?php

require_once "../config/database.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET["id"];


/* Delete fee record */

$stmt = $conn->prepare("
    DELETE FROM fees
    WHERE id = ?
");

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    header("Location: index.php");
    exit();

} else {

    echo "Failed to delete fee record.";

}

?>
```
