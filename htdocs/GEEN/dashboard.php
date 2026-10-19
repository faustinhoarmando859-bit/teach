 ```php
<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

require_once "config/database.php";

/* GET TOTAL STUDENTS */
$students = $conn->query(
    "SELECT COUNT(*) AS total FROM students"
)->fetch_assoc()['total'];

/* GET TOTAL TEACHERS */
$teachers = $conn->query(
    "SELECT COUNT(*) AS total FROM teachers"
)->fetch_assoc()['total'];

/* GET TOTAL CLASSES */
$classes = $conn->query(
    "SELECT COUNT(*) AS total FROM classes"
)->fetch_assoc()['total'];

/* GET TOTAL SUBJECTS */
$subjects = $conn->query(
    "SELECT COUNT(*) AS total FROM subjects"
)->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>GEEN - Dashboard</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<?php
$sidebarPathPrefix = "";
include "includes/sidebar.php";
?>


<!-- MAIN CONTENT -->

<div class="main">

    <!-- TOP BAR -->

    <div class="topbar">

        <div>

            <h1>Dashboard</h1>

            <p>
                Welcome,
                <strong>
                    <?php echo htmlspecialchars($_SESSION["full_name"]); ?>
                </strong>
            </p>

            <p>
                Role:
                <strong>
                    <?php echo htmlspecialchars(ucfirst($_SESSION["role"])); ?>
                </strong>
            </p>

        </div>

    </div>


    <!-- DASHBOARD CARDS -->

    <div class="dashboard-cards">

        <!-- STUDENTS -->

        <div class="card">

            <h3>Students</h3>

            <p class="number">
                <?php echo $students; ?>
            </p>

            <a href="students/index.php">
                View Students
            </a>

        </div>


        <!-- TEACHERS -->

        <div class="card">

            <h3>Teachers</h3>

            <p class="number">
                <?php echo $teachers; ?>
            </p>

            <a href="teachers/index.php">
                View Teachers
            </a>

        </div>


        <!-- CLASSES -->

        <div class="card">

            <h3>Classes</h3>

            <p class="number">
                <?php echo $classes; ?>
            </p>

            <a href="classes/index.php">
                View Classes
            </a>

        </div>


        <!-- SUBJECTS -->

        <div class="card">

            <h3>Subjects</h3>

            <p class="number">
                <?php echo $subjects; ?>
            </p>

            <a href="subjects/index.php">
                View Subjects
            </a>

        </div>

    </div>


    <!-- QUICK LINKS -->

    <div class="quick-links">

        <h2>Quick Actions</h2>

        <div class="actions">

            <a href="students/add.php">
                Add Student
            </a>

            <a href="teachers/add.php">
                Add Teacher
            </a>

            <a href="classes/add.php">
                Add Class
            </a>

            <a href="subjects/add.php">
                Add Subject
            </a>

        </div>

    </div>


</div>

</body>

</html>
```
