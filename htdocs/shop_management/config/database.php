<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$host = 'localhost'; $user = 'root'; $password = ''; $database = 'shop_management';
try { $conn = new mysqli($host, $user, $password, $database); $conn->set_charset('utf8mb4'); }
catch (mysqli_sql_exception $e) { http_response_code(500); exit('Database connection failed. Import database.sql in phpMyAdmin, then check config/database.php. Details: '.htmlspecialchars($e->getMessage())); }
