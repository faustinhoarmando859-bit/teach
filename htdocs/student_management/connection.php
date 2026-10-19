<?php
$connection = mysqli_connect('localhost', 'root', '', 'data-submission');

if (!$connection) {
    die('Connection failed: ' . mysqli_connect_error());
}

mysqli_set_charset($connection, 'utf8mb4');
?>