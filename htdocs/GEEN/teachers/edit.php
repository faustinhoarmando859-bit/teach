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

$sql = "SELECT * FROM teachers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Teacher not found.");
}

$teacher = $result->fetch_assoc();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $teacher_id = $_POST["teacher_id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $gender = $_POST["gender"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];

    $sql = "UPDATE teachers SET
            teacher_id = ?,
            first_name = ?,
            last_name = ?,
            gender = ?,
            phone = ?,
            email = ?,
            subject = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sssssssi",
        $teacher_id,
        $first_name,
        $last_name,
        $gender,
        $phone,
        $email,
        $subject,
        $id
    );

    if ($stmt->execute()) {

        header("Location: view.php");
        exit();

    } else {

        $error = "Failed to update teacher.";

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

<body>\n<?php include "../includes/sidebar.php"; ?>

<div class="main">\n\n    <div class="page-content">

    <div class="topbar">

        <h1>Edit Teacher</h1>

        <p>
            Welcome,
            <strong>
                <?php echo htmlspecialchars($_SESSION["username"]); ?>
            </strong>
        </p>

    </div>


    <?php if ($error != ""): ?>

        <div class="error">
            <?php echo $error; ?>
        </div>

    <?php endif; ?>


    <div class="form-container">

        <form method="POST" class="module-form">

            <div class="form-group">

                <label>Teacher ID</label>

                <input
                    type="text"
                    name="teacher_id"
                    value="<?php echo htmlspecialchars($teacher["teacher_id"]); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>First Name</label>

                <input
                    type="text"
                    name="first_name"
                    value="<?php echo htmlspecialchars($teacher["first_name"]); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>Last Name</label>

                <input
                    type="text"
                    name="last_name"
                    value="<?php echo htmlspecialchars($teacher["last_name"]); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>Gender</label>

                <select name="gender" required>

                    <option value="Male"
                        <?php if ($teacher["gender"] == "Male") echo "selected"; ?>>
                        Male
                    </option>

                    <option value="Female"
                        <?php if ($teacher["gender"] == "Female") echo "selected"; ?>>
                        Female
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label>Phone</label>

                <input
                    type="text"
                    name="phone"
                    value="<?php echo htmlspecialchars($teacher["phone"]); ?>"
                >

            </div>


            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    value="<?php echo htmlspecialchars($teacher["email"]); ?>"
                >

            </div>


            <div class="form-group">

                <label>Subject</label>

                <input
                    type="text"
                    name="subject"
                    value="<?php echo htmlspecialchars($teacher["subject"]); ?>"
                >

            </div>


            <button class="btn" type="submit">
                Update Teacher
            </button>

        </form>

    </div>\n\n    </div>\n\n</body>

</html>