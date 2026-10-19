 ```php
<?php

require_once "../config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $teacher_id = trim($_POST["teacher_id"]);
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $gender = trim($_POST["gender"]);
    $phone = !empty($_POST["phone"]) ? trim($_POST["phone"]) : NULL;
    $email = !empty($_POST["email"]) ? trim($_POST["email"]) : NULL;
    $subject = !empty($_POST["subject"]) ? trim($_POST["subject"]) : NULL;


    /* CHECK IF TEACHER ID ALREADY EXISTS */

    $check = $conn->prepare(
        "SELECT id FROM teachers WHERE teacher_id = ?"
    );

    $check->bind_param("s", $teacher_id);

    $check->execute();

    $check_result = $check->get_result();


    if ($check_result->num_rows > 0) {

        $message = "Teacher ID already exists.";

    } else {

        /* INSERT TEACHER */

        $stmt = $conn->prepare(
            "INSERT INTO teachers
            (teacher_id, first_name, last_name, gender, phone, email, subject)
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssssss",
            $teacher_id,
            $first_name,
            $last_name,
            $gender,
            $phone,
            $email,
            $subject
        );


        if ($stmt->execute()) {

            header("Location: index.php");
            exit();

        } else {

            $message = "Failed to add teacher.";

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

    \n    <link rel="stylesheet" href="../css/style.css"><title>Add Teacher</title>

</head>

<body>\n\n\n<?php include "../includes/sidebar.php"; ?>\n\n

    <h1>Add Teacher</h1>


    <?php if (!empty($message)): ?>

        <p>
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php endif; ?>


    <form method="POST" class="module-form" action="">


        <p>

            <label>
                Teacher ID
            </label>

            <br>

            <input
                type="text"
                name="teacher_id"
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
                Email
            </label>

            <br>

            <input
                type="email"
                name="email"
            >

        </p>


        <p>

            <label>
                Subject
            </label>

            <br>

            <input
                type="text"
                name="subject"
                placeholder="Example: Mathematics"
            >

        </p>


        <p>

            <button type="submit" class="submit">
                Save Teacher
            </button>

            <a href="index.php" class="cancel">
                Cancel
            </a>

        </p>


    </form>

</body>

</html>
```
