 <?php

session_start();

require_once "config/database.php";

if (!isset($_SESSION["reset_user_id"])) {
    header("Location: forgot_password.php");
    exit();
}

$user_id = $_SESSION["reset_user_id"];
$username = $_SESSION["reset_username"];

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    if ($new_password !== $confirm_password) {

        $error = "Passwords do not match.";

    } elseif (strlen($new_password) < 6) {

        $error = "Password must be at least 6 characters.";

    } else {

        $hashed_password = password_hash(
            $new_password,
            PASSWORD_DEFAULT
        );

        $stmt = $conn->prepare(
            "UPDATE users
             SET password = ?
             WHERE id = ?"
        );

        $stmt->bind_param(
            "si",
            $hashed_password,
            $user_id
        );

        if ($stmt->execute()) {

            unset($_SESSION["reset_user_id"]);
            unset($_SESSION["reset_username"]);

            header("Location: login.php?reset=success");
            exit();

        } else {

            $error = "Failed to reset password.";
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
            width: 420px;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.10);
        }

        h1 {
            text-align: center;
            color: #172554;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
        }

        .username {
            background: #eff6ff;
            color: #1e3a8a;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 20px;
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
            margin-bottom: 18px;
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

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 18px;
            text-align: center;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>🔑 Reset Password</h1>

    <p class="subtitle">
        Create a new password for your account.
    </p>


    <div class="username">

        Account:
        <strong>
            <?php echo htmlspecialchars($username); ?>
        </strong>

    </div>


    <?php if ($error != ""): ?>

        <div class="error">
            <?php echo htmlspecialchars($error); ?>
        </div>

    <?php endif; ?>


    <form method="POST">

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
            🔐 Reset Password
        </button>

    </form>

</div>

</body>

</html>