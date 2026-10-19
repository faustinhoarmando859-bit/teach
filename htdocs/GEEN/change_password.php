 <?php

session_start();

require_once "config/database.php";

// Check login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // Check new passwords
    if ($new_password !== $confirm_password) {

        $error = "New passwords do not match.";

    } elseif (strlen($new_password) < 6) {

        $error = "New password must be at least 6 characters.";

    } else {

        // Get current password
        $stmt = $conn->prepare(
            "SELECT password FROM users WHERE id = ? LIMIT 1"
        );

        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows !== 1) {

            $error = "User account not found.";

        } else {

            $user = $result->fetch_assoc();

            // Verify current password
            if (!password_verify($current_password, $user["password"])) {

                $error = "Current password is incorrect.";

            } else {

                // Hash new password
                $hashed_password = password_hash(
                    $new_password,
                    PASSWORD_DEFAULT
                );

                $update = $conn->prepare(
                    "UPDATE users SET password = ? WHERE id = ?"
                );

                $update->bind_param(
                    "si",
                    $hashed_password,
                    $user_id
                );

                if ($update->execute()) {

                    $message = "Password changed successfully.";

                } else {

                    $error = "Failed to change password.";

                }

                $update->close();
            }
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>GEEN</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 430px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.10);
        }

        h1 {
            text-align: center;
            color: #172554;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            margin-bottom: 17px;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            background: #172554;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #2563eb;
        }

        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 18px;
            text-align: center;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 18px;
            text-align: center;
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
            margin: 0 8px;
        }

        .links a:hover {
            text-decoration: underline;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>🔐 Change Password</h1>

    <p class="subtitle">
        Update your account password
    </p>


    <?php if ($message != ""): ?>

        <div class="success">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php endif; ?>


    <?php if ($error != ""): ?>

        <div class="error">
            <?php echo htmlspecialchars($error); ?>
        </div>

    <?php endif; ?>


    <form method="POST">

        <label>
            Current Password
        </label>

        <input
            type="password"
            name="current_password"
            placeholder="Enter current password"
            required
        >


        <label>
            New Password
        </label>

        <input
            type="password"
            name="new_password"
            placeholder="Enter new password"
            required
        >


        <label>
            Confirm New Password
        </label>

        <input
            type="password"
            name="confirm_password"
            placeholder="Confirm new password"
            required
        >


        <button type="submit">
            🔑 Change Password
        </button>

    </form>


    <div class="links">

        <a href="profile.php">
            👤 Profile
        </a>

        <a href="dashboard.php">
            🏠 Dashboard
        </a>

    </div>

</div>

</body>

</html>