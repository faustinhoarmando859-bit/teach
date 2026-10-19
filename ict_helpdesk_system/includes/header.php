<?php
require_once __DIR__ . '/auth.php';
require_login();
$pageTitle = $pageTitle ?? 'Dashboard';
$user = current_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?> | ICT Helpdesk</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a></li>
  </ul>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item"><span class="nav-link"><?= e($user['full_name']) ?> (<?= e(ucfirst($user['role'])) ?>)</span></li>
    <li class="nav-item"><a class="nav-link" href="/ict_helpdesk_system/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
  </ul>
</nav>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="/ict_helpdesk_system/dashboard.php" class="brand-link">
    <span class="brand-text font-weight-light ml-3"><b>ICT</b> Helpdesk</span>
  </a>
  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image"><i class="fas fa-user-circle fa-2x text-light"></i></div>
      <div class="info"><a href="#" class="d-block"><?= e($user['full_name']) ?></a></div>
    </div>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <li class="nav-item"><a href="/ict_helpdesk_system/dashboard.php" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
        <li class="nav-item"><a href="/ict_helpdesk_system/tickets/index.php" class="nav-link"><i class="nav-icon fas fa-ticket-alt"></i><p><?= $user['role']==='user' ? 'My Tickets' : 'Manage Tickets' ?></p></a></li>
        <?php if (is_staff()): ?>
        <li class="nav-item"><a href="/ict_helpdesk_system/equipment/index.php" class="nav-link"><i class="nav-icon fas fa-desktop"></i><p>Equipment</p></a></li>
        <?php endif; ?>
        <?php if ($user['role']==='admin'): ?>
        <li class="nav-item"><a href="/ict_helpdesk_system/users/index.php" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Users</p></a></li>
        <?php endif; ?>
        <li class="nav-item"><a href="/ict_helpdesk_system/logout.php" class="nav-link"><i class="nav-icon fas fa-sign-out-alt"></i><p>Logout</p></a></li>
      </ul>
    </nav>
  </div>
</aside>
<div class="content-wrapper">
<section class="content-header">
  <div class="container-fluid"><h1><?= e($pageTitle) ?></h1></div>
</section>
<section class="content"><div class="container-fluid">
