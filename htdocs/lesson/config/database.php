<?php 

$host ="localhost";
$dbname = "adminlte_demo";
$username = "root";
$password = "";

define('BASE_URL', '/lesson/');

try { 
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
    $pdo->exec("USE `$dbname`");
    $pdo->exec("CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL,
        course VARCHAR(100) NOT NULL,
        status ENUM('Active', 'Inactive') DEFAULT 'Active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    // Migrate table from earlier version (had no status column)
    if (!$pdo->query("SHOW COLUMNS FROM students LIKE 'status'")->fetch()) {
        $pdo->exec("ALTER TABLE students ADD status ENUM('Active','Inactive') DEFAULT 'Active'");
    }
    // Seed sample data only when empty
    if ($pdo->query("SELECT COUNT(*) FROM students")->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO students (name, email, course, status) VALUES
            ('John Doe', 'john@example.com', 'Computer Engineering', 'Active'),
            ('Mary Jane', 'mary@example.com', 'Information Technology', 'Active'),
            ('Peter John', 'peter@example.com', 'Computer Science', 'Inactive')");
    }
}
catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}