 <?php

$base_url = '/school_management';

$role = $_SESSION["role"] ?? "";

?>

<div class="sidebar">

    <div class="logo">
        <h2>🎓 GEEN</h2>
    </div>

    <ul class="menu">

        <!-- Everyone -->
        <li>
            <a href="<?php echo $base_url; ?>/dashboard.php">
                🏠 Dashboard
            </a>
        </li>
         <li>
              <a href="<?php echo $base_url; ?>/profile.php">
                 👤 My Profile
            </a>
           </li>
        <?php if ($role === "admin"): ?>

            <!-- ADMIN -->
            <li>
                <a href="<?php echo $base_url; ?>/admin/users.php">
                    👥 Users
                </a>
            </li>

            <li>
                <a href="<?php echo $base_url; ?>/students/view.php">
                    👨‍🎓 Students
                </a>
            </li>

            <li>
                <a href="<?php echo $base_url; ?>/teachers/view.php">
                    👩‍🏫 Teachers
                </a>
            </li>

            <li>
                <a href="<?php echo $base_url; ?>/classes/view.php">
                    🏫 Classes
                </a>
            </li>

            <li>
                <a href="<?php echo $base_url; ?>/subjects/view.php">
                    📚 Subjects
                </a>
            </li>

            <li>
                <a href="<?php echo $base_url; ?>/results/view.php">
                    📝 Results
                </a>
            </li>

            <li>
                <a href="<?php echo $base_url; ?>/attendance/view.php">
                    📅 Attendance
                </a>
            </li>

            <li>
                <a href="<?php echo $base_url; ?>/fees/view.php">
                    💰 Fees
                </a>
            </li>

            <li>
                <a href="<?php echo $base_url; ?>/parents/view.php">
                    👨‍👩‍👧 Parents
                </a>
            </li>

            <li>
                <a href="<?php echo $base_url; ?>/reports/view.php">
                    📊 Reports
                </a>
            </li>

        <?php elseif ($role === "teacher"): ?>

            <!-- TEACHER -->
            <li>
                <a href="<?php echo $base_url; ?>/students/view.php">
                    👨‍🎓 Students
                </a>
            </li>

            <li>
                <a href="<?php echo $base_url; ?>/results/view.php">
                    📝 Results
                </a>
            </li>

            <li>
                <a href="<?php echo $base_url; ?>/attendance/view.php">
                    📅 Attendance
                </a>
            </li>

        <?php elseif ($role === "staff"): ?>

            <!-- STAFF -->
            <li>
                <a href="<?php echo $base_url; ?>/students/view.php">
                    👨‍🎓 Students
                </a>
            </li>

            <li>
                <a href="<?php echo $base_url; ?>/fees/view.php">
                    💰 Fees
                </a>
            </li>

            <li>
                <a href="<?php echo $base_url; ?>/parents/view.php">
                    👨‍👩‍👧 Parents
                </a>
            </li>

        <?php elseif ($role === "parent"): ?>

            <!-- PARENT -->
            <li>
                <a href="<?php echo $base_url; ?>/students/view.php">
                    👨‍🎓 My Child
                </a>
            </li>

            <li>
                <a href="<?php echo $base_url; ?>/results/view.php">
                    📝 Results
                </a>
            </li>

            <li>
                <a href="<?php echo $base_url; ?>/attendance/view.php">
                    📅 Attendance
                </a>
            </li>

            <li>
                <a href="<?php echo $base_url; ?>/fees/view.php">
                    💰 Fees
                </a>
            </li>

        <?php endif; ?>

        <li>
            <a href="<?php echo $base_url; ?>/logout.php">
                🚪 Logout
            </a>
        </li>

    </ul>

</div>