<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit();
}

require_once "../config/database.php";


$search = "";

if (isset($_GET["search"])) {
    $search = trim($_GET["search"]);
}

if ($search != "") {

    $sql = "SELECT * FROM students
            WHERE student_id LIKE ?
            OR first_name LIKE ?
            OR last_name LIKE ?
            OR class LIKE ?
            ORDER BY id DESC";

    $stmt = $conn->prepare($sql);

    $searchTerm = "%" . $search . "%";

    $stmt->bind_param(
        "ssss",
        $searchTerm,
        $searchTerm,
        $searchTerm,
        $searchTerm
    );

    $stmt->execute();

    $result = $stmt->get_result();

} else {

    $sql = "SELECT * FROM students ORDER BY id DESC";

    $result = $conn->query($sql);
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

    <div class="page-header">

        <h1>Students</h1>

        <a href="add.php" class="add-btn">
            + Add Student
        </a>

    </div>


    <div class="content">
     <div class="search-box">

    <form method="GET" class="search-form">

        <input
            type="text"
            name="search"
            placeholder="Search by ID, name or class..."
            value="<?php echo htmlspecialchars($search); ?>"
        >

        <button type="submit" class="submit">
            Search
        </button>

        <a href="view.php" class="cancel">
            Clear
        </a>

    </form>

</div>
        <div class="table-wrapper"><table class="data-table">

            <thead>

                <tr>

                    <th>#</th>
                    <th>Student ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Class</th>
                    <th>Phone</th>
                    <th>Actions</th>

                </tr>

            </thead>


            <tbody>

            <?php if ($result->num_rows > 0): ?>

                <?php while ($student = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?php echo $student["id"]; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($student["student_id"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($student["first_name"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($student["last_name"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($student["gender"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($student["date_of_birth"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($student["class"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($student["phone"]); ?>
                        </td>

                        <td>

                            <a
                                href="edit.php?id=<?php echo $student["id"]; ?>"
                                class="edit-btn"
                            >
                                Edit
                            </a>

                            <a
                                href="delete.php?id=<?php echo $student["id"]; ?>"
                                class="delete-btn"
                                onclick="return confirm('Are you sure you want to delete this student?');"
                            >
                                Delete
                            </a>

                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>

                    <td colspan="9" class="empty">

                        No students found.

                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table></div>

    </div>\n\n    </div>\n\n</body>

</html>