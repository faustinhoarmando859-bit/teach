 ```php
<?php

require_once "../config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $student_id = trim($_POST["student_id"]);
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $gender = trim($_POST["gender"]);
    $date_of_birth = !empty($_POST["date_of_birth"]) ? $_POST["date_of_birth"] : NULL;
    $class = !empty($_POST["class"]) ? trim($_POST["class"]) : NULL;
    $phone = !empty($_POST["phone"]) ? trim($_POST["phone"]) : NULL;
    $address = !empty($_POST["address"]) ? trim($_POST["address"]) : NULL;


    /* CHECK IF STUDENT ID ALREADY EXISTS */

    $check = $conn->prepare(
        "SELECT id FROM students WHERE student_id = ?"
    );

    $check->bind_param("s", $student_id);

    $check->execute();

    $check_result = $check->get_result();


    if ($check_result->num_rows > 0) {

        $message = "Student ID already exists.";

    } else {

        /* INSERT STUDENT */

        $stmt = $conn->prepare(
            "INSERT INTO students
            (student_id, first_name, last_name, gender, date_of_birth, class, phone, address)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssssssss",
            $student_id,
            $first_name,
            $last_name,
            $gender,
            $date_of_birth,
            $class,
            $phone,
            $address
        );


        if ($stmt->execute()) {

            header("Location: index.php");
            exit();

        } else {

            $message = "Failed to add student.";

        }

        $stmt->close();
    }

    $check->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    \n    <link rel="stylesheet" href="../css/style.css"><title>Add Student</title>

</head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

    <h1>Add Student</h1>


    <?php if (!empty($message)): ?>

        <p>
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php endif; ?>


    <form method="POST" class="module-form" action="">


        <p>

            <label>
                Student ID
            </label>

            <br>

            <input
                type="text"
                name="student_id"
                required
            >

        </p>


        <p>

            <label>
                First Name
            </label>

            <br>

            <input
                type="text"
                name="first_name"
                required
            >

        </p>


        <p>

            <label>
                Last Name
            </label>

            <br>

            <input
                type="text"
                name="last_name"
                required
            >

        </p>


        <p>

            <label>
                Gender
            </label>

            <br>

            <select name="gender" required>

                <option value="">
                    Select Gender
                </option>

                <option value="Male">
                    Male
                </option>

                <option value="Female">
                    Female
                </option>

            </select>

        </p>


        <p>

            <label>
                Date of Birth
            </label>

            <br>

            <input
                type="date"
                name="date_of_birth"
            >

        </p>


        <p>

            <label>
                Class
            </label>

            <br>

            <input
                type="text"
                name="class"
                placeholder="Example: Form 1"
            >

        </p>


        <p>

            <label>
                Phone
            </label>

            <br>

            <input
                type="text"
                name="phone"
            >

        </p>


        <p>

            <label>
                Address
            </label>

            <br>

            <textarea
                name="address"
                rows="4"
                cols="40"
            ></textarea>

        </p>


        <p>

            <button type="submit" class="submit">
                Save Student
            </button>

            <a href="index.php" class="cancel">
                Cancel
            </a>

        </p>


    </form>

</body>

</html>
```
