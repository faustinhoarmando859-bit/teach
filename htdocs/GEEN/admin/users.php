<?php

session_start();

require_once "../config/database.php";

/*
|--------------------------------------------------------------------------
| ADMIN ACCESS PROTECTION
|--------------------------------------------------------------------------
*/

if (
    !isset($_SESSION["user_id"]) ||
    $_SESSION["role"] !== "admin"
) {
    header("Location: ../dashboard.php");
    exit();
}


/*
|--------------------------------------------------------------------------
| APPROVE USER
|--------------------------------------------------------------------------
*/

if (isset($_GET["approve"])) {

    $id = intval($_GET["approve"]);

    $stmt = $conn->prepare(
        "UPDATE users SET status = 'active' WHERE id = ?"
    );

    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        die("Approval failed: " . $stmt->error);
    }

    $stmt->close();

    header("Location: users.php");
    exit();
}


/*
|--------------------------------------------------------------------------
| BLOCK USER
|--------------------------------------------------------------------------
*/

if (isset($_GET["block"])) {

    $id = intval($_GET["block"]);

    // Prevent admin from blocking himself
    if ($id != $_SESSION["user_id"]) {

        $stmt = $conn->prepare(
            "UPDATE users SET status = 'blocked' WHERE id = ?"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: users.php");
    exit();
}


/*
|--------------------------------------------------------------------------
| ACTIVATE / UNBLOCK USER
|--------------------------------------------------------------------------
*/

if (isset($_GET["activate"])) {

    $id = intval($_GET["activate"]);

    $stmt = $conn->prepare(
        "UPDATE users SET status = 'active' WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: users.php");
    exit();
}


/*
|--------------------------------------------------------------------------
| DELETE USER
|--------------------------------------------------------------------------
*/

if (isset($_GET["delete"])) {

    $id = intval($_GET["delete"]);

    // Prevent admin from deleting himself
    if ($id != $_SESSION["user_id"]) {

        $stmt = $conn->prepare(
            "DELETE FROM users WHERE id = ?"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: users.php");
    exit();
}


/*
|--------------------------------------------------------------------------
| GET ALL USERS
|--------------------------------------------------------------------------
*/

$result = $conn->query(
    "SELECT id, full_name, username, email, role, status, created_at
     FROM users
     ORDER BY created_at DESC"
);

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
            max-width: 1250px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 15px;
            flex-wrap: wrap;
        }

        h1 {
            color: #172554;
        }

        .back {
            display: inline-block;
            text-decoration: none;
            background: #172554;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
        }

        .back:hover {
            background: #2563eb;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th {
            background: #172554;
            color: white;
            padding: 13px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background: #f8fafc;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .active {
            background: #d1fae5;
            color: #065f46;
        }

        .blocked {
            background: #fee2e2;
            color: #991b1b;
        }

        .role {
            font-weight: bold;
            text-transform: capitalize;
        }

        .btn {
            display: inline-block;
            padding: 7px 10px;
            margin: 2px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-size: 13px;
            border: none;
            cursor: pointer;
        }

        .approve {
            background: #16a34a;
        }

        .approve:hover {
            background: #15803d;
        }

        .block {
            background: #dc2626;
        }

        .block:hover {
            background: #b91c1c;
        }

        .activate {
            background: #2563eb;
        }

        .activate:hover {
            background: #1d4ed8;
        }

        .delete {
            background: #7f1d1d;
        }

        .delete:hover {
            background: #991b1b;
        }

        .self {
            color: #666;
            font-size: 13px;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #666;
        }

        @media (max-width: 600px) {

            body {
                padding: 10px;
            }

            .container {
                padding: 15px;
            }

            h1 {
                font-size: 22px;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <div class="top">

        <h1>👥 User Management</h1>

        <a
            href="../dashboard.php"
            class="back"
        >
            ← Dashboard
        </a>

    </div>


    <div class="table-container">

        <table>

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Full Name</th>

                    <th>Username</th>

                    <th>Email</th>

                    <th>Role</th>

                    <th>Status</th>

                    <th>Created</th>

                    <th>Actions</th>

                </tr>

            </thead>


            <tbody>

            <?php if ($result->num_rows > 0): ?>

                <?php while ($user = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?php echo $user["id"]; ?>
                        </td>


                        <td>
                            <?php
                            echo htmlspecialchars(
                                $user["full_name"]
                            );
                            ?>
                        </td>


                        <td>
                            <?php
                            echo htmlspecialchars(
                                $user["username"]
                            );
                            ?>
                        </td>


                        <td>
                            <?php
                            echo htmlspecialchars(
                                $user["email"]
                            );
                            ?>
                        </td>


                        <td class="role">

                            <?php
                            echo htmlspecialchars(
                                $user["role"]
                            );
                            ?>

                        </td>


                        <td>

                            <span
                                class="status
                                <?php
                                echo htmlspecialchars(
                                    $user["status"]
                                );
                                ?>"
                            >

                                <?php
                                echo ucfirst(
                                    htmlspecialchars(
                                        $user["status"]
                                    )
                                );
                                ?>

                            </span>

                        </td>


                        <td>

                            <?php
                            echo htmlspecialchars(
                                $user["created_at"]
                            );
                            ?>

                        </td>


                        <td>

                            <?php if (
                                $user["id"] ==
                                $_SESSION["user_id"]
                            ): ?>

                                <span class="self">
                                    Current Admin
                                </span>

                            <?php else: ?>


                                <?php if (
                                    $user["status"] ==
                                    "pending"
                                ): ?>

                                    <a
                                        href="users.php?approve=<?php echo $user["id"]; ?>"
                                        class="btn approve"
                                        onclick="return confirm('Approve this user?');"
                                    >
                                        ✅ Approve
                                    </a>

                                <?php endif; ?>


                                <?php if (
                                    $user["status"] ==
                                    "active"
                                ): ?>

                                    <a
                                        href="users.php?block=<?php echo $user["id"]; ?>"
                                        class="btn block"
                                        onclick="return confirm('Block this user?');"
                                    >
                                        🚫 Block
                                    </a>

                                <?php endif; ?>


                                <?php if (
                                    $user["status"] ==
                                    "blocked"
                                ): ?>

                                    <a
                                        href="users.php?activate=<?php echo $user["id"]; ?>"
                                        class="btn activate"
                                        onclick="return confirm('Activate this user?');"
                                    >
                                        🔓 Activate
                                    </a>

                                <?php endif; ?>


                                <a
                                    href="users.php?delete=<?php echo $user["id"]; ?>"
                                    class="btn delete"
                                    onclick="return confirm('Are you sure you want to DELETE this user?');"
                                >
                                    🗑️ Delete
                                </a>


                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>

                    <td
                        colspan="8"
                        class="empty"
                    >
                        No users found.
                    </td>

                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

</body>

</html>