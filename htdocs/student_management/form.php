<?php
require 'connection.php';

$result = mysqli_query($connection, 'SELECT id, full_name, email, phone, course FROM students ORDER BY id');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>STUDENT MANAGEMENT SYSTEM</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 10px; box-sizing: border-box; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #cccccc; padding: 10px; text-align: left; }
        button { padding: 8px 12px; background-color: #eeeeee; border: 1px solid #666666; color: #000000; cursor: pointer; }
        .action-form { display: inline; }
        .message { padding: 10px; background: #eeeeee; border: 1px solid #cccccc; }
    </style>
</head>
<body>
    <h1>STUDENT MANAGEMENT SYSTEM</h1>
    <?php if (isset($_GET['message'])): ?>
        <p class="message"><?php echo htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <form action="process.php" method="POST">
        <input type="hidden" name="action" value="insert">
        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="course">Course</label>
            <input type="text" id="course" name="course" required>
        </div>
        <button type="submit">Submit Data</button>
    </form>

    <h2>Student Records</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Course</th>
            <th>Actions</th>
        </tr>
        <?php while ($student = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo (int) $student['id']; ?></td>
            <td><?php echo htmlspecialchars($student['full_name'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($student['email'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($student['phone'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($student['course'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
                <form class="action-form" action="process.php" method="GET">
                    <input type="hidden" name="id" value="<?php echo (int) $student['id']; ?>">
                    <button type="submit" name="action" value="view">View</button>
                </form>
                <form class="action-form" action="process.php" method="GET">
                    <input type="hidden" name="id" value="<?php echo (int) $student['id']; ?>">
                    <button type="submit" name="action" value="edit">Edit</button>
                </form>
                <form class="action-form" action="process.php" method="GET">
                    <input type="hidden" name="id" value="<?php echo (int) $student['id']; ?>">
                    <button type="submit" name="action" value="delete">Delete</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>