 <?php
require_once "config/database.php";

$query = "SELECT COUNT(*) AS total FROM students";
$result = $conn->query($query);
$row = $result->fetch_assoc();

$total_students = $row['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Attendance System</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="sidebar">

    <h2>🎓 Attendance</h2>

    <a href="index.php">🏠 Dashboard</a>
    <a href="students/view.php">👨‍🎓 Students</a>
    <a href="attendance/mark.php">✅ Attendance</a>
    <a href="attendance/report.php">📊 Reports</a>

</div>


<div class="main">

    <div class="header">

        <h1>Student Attendance System</h1>

        <p>
            Welcome to the school attendance dashboard
        </p>

    </div>


    <div class="cards">

        <div class="card">

            <div class="icon">👨‍🎓</div>

            <h3>Total Students</h3>

            <h2>
                <?php echo $total_students; ?>
            </h2>

        </div>


        <div class="card">

            <div class="icon">✅</div>

            <h3>Present Today</h3>

            <h2>0</h2>

        </div>


        <div class="card">

            <div class="icon">❌</div>

            <h3>Absent Today</h3>

            <h2>0</h2>

        </div>


        <div class="card">

            <div class="icon">📅</div>

            <h3>Today</h3>

            <h2>
                <?php echo date("d/m/Y"); ?>
            </h2>

        </div>

    </div>


    <div class="welcome">

        <h2>Welcome 👋</h2>

        <p>
            Manage students and record daily attendance
            easily using this system.
        </p>

        <a href="students/add.php">
            ➕ Add Student
        </a>

    </div>

</div>

</body>
</html>