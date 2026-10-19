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

    $sql = "SELECT * FROM teachers
            WHERE teacher_id LIKE ?
            OR first_name LIKE ?
            OR last_name LIKE ?
            OR subject LIKE ?
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

    $sql = "SELECT * FROM teachers ORDER BY id DESC";

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

<body>\n<?php include "../includes/sidebar.php"; ?>

<div class="main">\n\n    <div class="page-content">

    <div class="topbar">

        <h1>Teachers Management</h1>

    </div>


    <div class="page-header">

        <h1>Teachers</h1>

        <a href="add.php" class="add-btn">
            + Add Teacher
        </a>

    </div>


    <div class="content">

        <!-- SEARCH -->

        <div class="search-box">

            <form method="GET" class="search-form">

                <input
                    type="text"
                    name="search"
                    placeholder="Search by ID, name or subject..."
                    value="<?php echo htmlspecialchars($search); ?>"
                >

                <button type="submit" class="submit">
                    Search
                </button>

                <a href="view.php" class="clear-btn">
                    Clear
                </a>

            </form>

        </div>


        <!-- TEACHERS TABLE -->

        <div class="table-wrapper"><table class="data-table">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Teacher ID</th>

                    <th>First Name</th>

                    <th>Last Name</th>

                    <th>Gender</th>

                    <th>Phone</th>

                    <th>Email</th>

                    <th>Subject</th>

                    <th>Actions</th>

                </tr>

            </thead>


            <tbody>

            <?php if ($result->num_rows > 0): ?>

                <?php while ($teacher = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?php echo $teacher["id"]; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($teacher["teacher_id"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($teacher["first_name"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($teacher["last_name"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($teacher["gender"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($teacher["phone"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($teacher["email"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($teacher["subject"]); ?>
                        </td>

                        <td>

                            <a
                                href="edit.php?id=<?php echo $teacher["id"]; ?>"
                                class="edit-btn"
                            >
                                Edit
                            </a>

                            <a
                                href="delete.php?id=<?php echo $teacher["id"]; ?>"
                                class="delete-btn"
                                onclick="return confirm('Are you sure you want to delete this teacher?');"
                            >
                                Delete
                            </a>

                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>

                    <td colspan="9" class="empty">
                        No teachers found.
                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table></div>

    </div>\n\n    </div>\n\n</body>

</html>