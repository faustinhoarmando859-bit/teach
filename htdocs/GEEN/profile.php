 <?php

session_start();

require_once "config/database.php";

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT id, full_name, username, email, role, status, created_at
        FROM users
        WHERE id = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$user = $result->fetch_assoc();

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
            padding: 30px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            gap: 15px;
            flex-wrap: wrap;
        }

        h1 {
            color: #172554;
        }

        .back {
            text-decoration: none;
            background: #172554;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
        }

        .back:hover {
            background: #2563eb;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .avatar {
            width: 90px;
            height: 90px;
            margin: auto;
            border-radius: 50%;
            background: #172554;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin-bottom: 15px;
        }

        .profile-header h2 {
            color: #172554;
            margin-bottom: 5px;
        }

        .profile-header p {
            color: #666;
        }

        .info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .info-box {
            background: #f8fafc;
            padding: 18px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .info-box label {
            display: block;
            color: #666;
            font-size: 13px;
            margin-bottom: 7px;
        }

        .info-box strong {
            color: #172554;
            font-size: 16px;
        }

        .status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
        }

        .active {
            background: #d1fae5;
            color: #065f46;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .blocked {
            background: #fee2e2;
            color: #991b1b;
        }

        .role {
            text-transform: capitalize;
        }

        .actions {
            margin-top: 30px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            text-decoration: none;
            padding: 11px 18px;
            border-radius: 6px;
            color: white;
            background: #2563eb;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .logout {
            background: #dc2626;
        }

        .logout:hover {
            background: #b91c1c;
        }

        @media (max-width: 600px) {

            body {
                padding: 10px;
            }

            .container {
                padding: 20px;
            }

            .info {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <div class="top">

        <h1>👤 My Profile</h1>

        <a
            href="dashboard.php"
            class="back"
        >
            ← Dashboard
        </a>

    </div>


    <div class="profile-header">

        <div class="avatar">
            👤
        </div>

        <h2>
            <?php echo htmlspecialchars($user["full_name"]); ?>
        </h2>

        <p>
            @<?php echo htmlspecialchars($user["username"]); ?>
        </p>

    </div>


    <div class="info">

        <div class="info-box">

            <label>Full Name</label>

            <strong>
                <?php echo htmlspecialchars($user["full_name"]); ?>
            </strong>

        </div>


        <div class="info-box">

            <label>Username</label>

            <strong>
                <?php echo htmlspecialchars($user["username"]); ?>
            </strong>

        </div>


        <div class="info-box">

            <label>Email</label>

            <strong>
                <?php echo htmlspecialchars($user["email"]); ?>
            </strong>

        </div>


        <div class="info-box">

            <label>Role</label>

            <strong class="role">
                <?php echo htmlspecialchars($user["role"]); ?>
            </strong>

        </div>


        <div class="info-box">

            <label>Account Status</label>

            <strong>

                <span
                    class="status
                    <?php echo htmlspecialchars($user["status"]); ?>"
                >

                    <?php
                    echo ucfirst(
                        htmlspecialchars($user["status"])
                    );
                    ?>

                </span>

            </strong>

        </div>


        <div class="info-box">

            <label>Registered On</label>

            <strong>
                <?php echo htmlspecialchars($user["created_at"]); ?>
            </strong>

        </div>

    </div>


    <div class="actions">
<a
    href="change_password.php"
    class="btn"
>
    🔐 Change Password
</a>
        <a
            href="dashboard.php"
            class="btn"
        >
            🏠 Dashboard
        </a>

        <a
            href="logout.php"
            class="btn logout"
        >
            🚪 Logout
        </a>

    </div>

</div>

</body>

</html>