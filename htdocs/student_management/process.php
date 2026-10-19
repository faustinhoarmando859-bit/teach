<?php
require 'connection.php';

function escapeHtml($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function getStudent($connection, $id)
{
    $result = mysqli_query($connection, 'SELECT id, full_name, email, phone, course FROM students WHERE id = ' . (int) $id);
    return $result ? mysqli_fetch_assoc($result) : null;
}

function redirectToForm($message = '')
{
    $url = 'form.php';
    if ($message !== '') {
        $url .= '?message=' . urlencode($message);
    }
    header('Location: ' . $url);
    exit;
}


$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'insert' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $course = trim($_POST['course'] ?? '');

    if ($fullName === '' || $email === '' || $phone === '' || $course === '') {
        redirectToForm('Please complete every field.');
    }

    $statement = mysqli_prepare($connection, 'INSERT INTO students (full_name, email, phone, course) VALUES (?, ?, ?, ?)');
    mysqli_stmt_bind_param($statement, 'ssss', $fullName, $email, $phone, $course);
    $saved = mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    redirectToForm($saved ? 'Student added successfully.' : 'Could not add the student. Check that the email is unique.');
}

if ($action === 'view' || $action === 'edit') {
    $id = (int) ($_GET['id'] ?? 0);
    $student = $id > 0 ? getStudent($connection, $id) : null;

    if (!$student) {
        redirectToForm('Student record not found.');
    }

    if ($action === 'view') {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>View Student</title>
        </head>
        <body>
            <h1>Student Details</h1>
            <p><strong>Full Name:</strong> <?php echo escapeHtml($student['full_name']); ?></p>
            <p><strong>Email:</strong> <?php echo escapeHtml($student['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo escapeHtml($student['phone']); ?></p>
            <p><strong>Course:</strong> <?php echo escapeHtml($student['course']); ?></p>
            <p><a href="form.php">Back to Records</a></p>
        </body>
        </html>
        <?php
        exit;
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit Student</title>
    </head>
    <body>
        <h1>Edit Student</h1>
        <form action="process.php" method="POST">
            <input type="hidden" name="id" value="<?php echo (int) $student['id']; ?>">
            <input type="hidden" name="action" value="update">
            <div>
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo escapeHtml($student['full_name']); ?>" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo escapeHtml($student['email']); ?>" required>
            </div>
            <div>
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" value="<?php echo escapeHtml($student['phone']); ?>" required>
            </div>
            <div>
                <label for="course">Course</label>
                <input type="text" id="course" name="course" value="<?php echo escapeHtml($student['course']); ?>" required>
            </div>
            <button type="submit">Update Data</button>
        </form>
        <p><a href="form.php">Back to Records</a></p>
    </body>
    </html>
    <?php
    exit;
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['id'] ?? 0);
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $course = trim($_POST['course'] ?? '');

    if ($id < 1 || $fullName === '' || $email === '' || $phone === '' || $course === '') {
        redirectToForm('Please provide a valid student and complete every field.');
    }

    $statement = mysqli_prepare($connection, 'UPDATE students SET full_name = ?, email = ?, phone = ?, course = ? WHERE id = ?');
    mysqli_stmt_bind_param($statement, 'ssssi', $fullName, $email, $phone, $course, $id);
    $saved = mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);

    redirectToForm($saved ? 'Student updated successfully.' : 'Could not update the student. Check that the email is unique.');
}

if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = (int) ($_GET['id'] ?? 0);

    if ($id < 1) {
        redirectToForm('Student record not found.');
    }

}
      $statement = mysqli_prepare($connection, "DELETE FROM students WHERE id = ?");
      mysqli_stmt_bind_param($statement, "i", $id);
      $saved = mysqli_stmt_execute($statement);
      mysqli_stmt_close($statement);

if ($saved) {
    // Punguza ID za students wote waliofuata
    $renumber = mysqli_query(
        $connection,
        "UPDATE students SET id = id - 1 WHERE id > $id"
    );

    // Rekebisha AUTO_INCREMENT
    $maxResult = mysqli_query($connection, "SELECT MAX(id) AS max_id FROM students");
    $maxRow = mysqli_fetch_assoc($maxResult);
    $nextId = ($maxRow['max_id'] ?? 0) + 1;

    mysqli_query(
        $connection,
        "ALTER TABLE students AUTO_INCREMENT = $nextId"
    );
}

redirectToForm($saved ? 'Student deleted successfully.' : 'Could not delete student.');

redirectToForm();
?>