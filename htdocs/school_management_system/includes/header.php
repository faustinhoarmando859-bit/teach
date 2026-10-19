<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
$pageTitle = $pageTitle ?? 'Dashboard';
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($pageTitle) ?> | School Management</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a></li>
  </ul>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item"><span class="nav-link"><?= htmlspecialchars($_SESSION['full_name'] ?? 'Administrator') ?></span></li>
    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
  </ul>
</nav>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="index.php" class="brand-link">
    <span class="brand-text font-weight-light ml-3">School Manager</span>
  </a>
  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image"><i class="fas fa-user-shield text-white mt-2"></i></div>
      <div class="info"><a href="#" class="d-block"><?= htmlspecialchars($_SESSION['full_name'] ?? 'Administrator') ?></a></div>
    </div>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
        <li class="nav-item"><a href="index.php" class="nav-link <?= $currentPage === 'index.php' ? 'active' : '' ?>"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
        <li class="nav-item"><a href="students.php" class="nav-link <?= $currentPage === 'students.php' ? 'active' : '' ?>"><i class="nav-icon fas fa-user-graduate"></i><p>Students</p></a></li>
        <li class="nav-item"><a href="classes.php" class="nav-link <?= $currentPage === 'classes.php' ? 'active' : '' ?>"><i class="nav-icon fas fa-school"></i><p>Classes</p></a></li>
      </ul>
    </nav>
  </div>
</aside>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid"><h1><?= htmlspecialchars($pageTitle) ?></h1></div>
  </section>
  <section class="content"><div class="container-fluid">
