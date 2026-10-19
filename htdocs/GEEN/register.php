<?php

session_start();

require_once "config/database.php";

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = trim($_POST["full_name"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $role = $_POST["role"];

    // Check password
    if ($password !== $confirm_password) {

        $error = "Passwords do not match.";

    } else {

        // Check username or email already exists
        $check = $conn->prepare(
            "SELECT id FROM users WHERE username = ? OR email = ?"
        );

        $check->bind_param(
            "ss",
            $username,
            $email
        );

        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $error = "Username or email already exists.";

        } else {

            // Hash password
            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // New users wait for admin approval
            $status = "pending";

            $sql = "INSERT INTO users
                    (full_name, username, email, password, role, status)
                    VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param(
                "ssssss",
                $full_name,
                $username,
                $email,
                $hashed_password,
                $role,
                $status
            );

            if ($stmt->execute()) {

                $message = "Registration successful! Please wait for admin approval.";

            } else {

                $error = "Registration failed. Please try again.";

            }
        }
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>GEEN</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .register-container {
            width: 420px;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
        }

        .register-container h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #1e3a8a;
        }

        .register-container p {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 17px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            background: #1e3a8a;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #162d6b;
        }

        .success {
            background: #d1fae5;
            color: #065f46;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            text-align: center;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 6px;
            text-align: center;
        }

        .login-link {
            margin-top: 20px;
            text-align: center;
        }

        .login-link a {
            color: #1e3a8a;
            text-decoration: none;
            font-weight: bold;
        }

    </style>

</head>

<body>

<div class="register-container">

    <h1>🎓 GEEN</h1>

    <p>Create your account</p>


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

        <label>Full Name</label>

        <input
            type="text"
            name="full_name"
            placeholder="Enter your full name"
            required
        >


        <label>Username</label>

        <input
            type="text"
            name="username"
            placeholder="Choose username"
            required
        >


        <label>Email</label>

        <input
            type="email"
            name="email"
            placeholder="Enter email"
            required
        >


        <label>Password</label>

        <input
            type="password"
            name="password"
            placeholder="Create password"
            required
        >


        <label>Confirm Password</label>

        <input
            type="password"
            name="confirm_password"
            placeholder="Confirm password"
            required
        >


        <label>Account Type</label>

        <select name="role" required>

            <option value="">
                Select account type
            </option>

            <option value="teacher">
                Teacher
            </option>

            <option value="staff">
                Staff
            </option>

            <option value="parent">
                Parent
            </option>

        </select>


        <button type="submit">
            Create Account
        </button>

    </form>


    <div class="login-link">

        Already have an account?

        <a href="login.php">
            Login
        </a>

    </div>

</div>

</body>

</html>