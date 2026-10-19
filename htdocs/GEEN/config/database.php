<?php

$config = require __DIR__ . "/app.php";

$host = $config["db"]["host"];
$username = $config["db"]["user"];
$password = $config["db"]["password"];
$database = $config["db"]["name"];
$port = $config["db"]["port"];

$conn = new mysqli($host, $username, $password, $database, (int) $port);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>