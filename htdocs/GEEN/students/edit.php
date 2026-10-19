<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit();
}

require_once "../config/database.php";

if (!isset($_GET["id"])) {
    header("Location: view.php");
    exit();
}

$id = intval($_GET["id"]);

$sql = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Student not found.");
}

$student = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_id = $_POST["student_id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $gender = $_POST["gender"];
    $date_of_birth = $_POST["date_of_birth"];
    $class = $_POST["class"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    $sql = "UPDATE students SET
            student_id = ?,
            first_name = ?,
            last_name = ?,
            gender = ?,
            date_of_birth = ?,
            class = ?,
            phone = ?,
            address = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssssssssi",
        $student_id,
        $first_name,
        $last_name,
        $gender,
        $date_of_birth,
        $class,
        $phone,
        $address,
        $id
    );

    if ($stmt->execute()) {
        header("Location: view.php");
        exit();
    } else {
        $error = "Failed to update student.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>GEEN</title>

    <link rel="stylesheet" href="../css/style.css">

    </head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

<div class="main">\n\n    <div class="page-content">

    <h1>Edit Student</h1>

    <br>

    <?php if (isset($error)): ?>

        <div class="error">
            <?php echo $error; ?>
        </div>

    <?php endif; ?>


    <div class="form-container">

        <form method="POST" class="module-form">

            <div class="form-group">

                <label>Student ID</label>

                <input
                    type="text"
                    name="student_id"
                    value="<?php echo htmlspecialchars($student["student_id"]); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>First Name</label>

                <input
                    type="text"
                    name="first_name"
                    value="<?php echo htmlspecialchars($student["first_name"]); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>Last Name</label>

                <input
                    type="text"
                    name="last_name"
                    value="<?php echo htmlspecialchars($student["last_name"]); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>Gender</label>

                <select name="gender" required>

                    <option value="Male"
                        <?php if ($student["gender"] == "Male") echo "selected"; ?>>
                        Male
                    </option>

                    <option value="Female"
                        <?php if ($student["gender"] == "Female") echo "selected"; ?>>
                        Female
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>Date of Birth</label>

                <input
                    type="date"
                    name="date_of_birth"
                    value="<?php echo htmlspecialchars($student["date_of_birth"]); ?>"
                >

            </div>


            <div class="form-group">

                <label>Class</label>

                <input
                    type="text"
                    name="class"
                    value="<?php echo htmlspecialchars($student["class"]); ?>"
                >

            </div>


            <div class="form-group">

                <label>Phone</label>

                <input
                    type="text"
                    name="phone"
                    value="<?php echo htmlspecialchars($student["phone"]); ?>"
                >

            </div>


            <div class="form-group">

                <label>Address</label>

                <input
                    type="text"
                    name="address"
                    value="<?php echo htmlspecialchars($student["address"]); ?>"
                >

            </div>


            <button class="btn" type="submit">
                Update Student
            </button>

        </form>

    </div>\n\n    </div>\n\n</body>

</html>