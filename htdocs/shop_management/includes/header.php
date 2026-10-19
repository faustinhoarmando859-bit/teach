<?php
$pageTitle = $pageTitle ?? 'Dashboard';
$active = $active ?? '';
$adminName = 'GEEN';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=e($pageTitle)?> | Shop Manager</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
	<nav class="main-header navbar navbar-expand navbar-white navbar-light">
		<ul class="navbar-nav">
			<li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a></li>
			<li class="nav-item d-none d-sm-inline-block"><a href="dashboard.php" class="nav-link">Shop Manager</a></li>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item"><a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt mr-1"></i>Sign out</a></li>
		</ul>
	</nav>
	<aside class="main-sidebar sidebar-dark-primary elevation-4">
		<a href="dashboard.php" class="brand-link text-center"><span class="brand-text font-weight-light">Shop Manager</span></a>
		<div class="sidebar">
			<div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
				<div class="image"><img src="assets/image/admin.png" class="img-circle elevation-2" alt="Admin profile"></div>
				<div class="info"><span class="d-block text-white"><?=e($adminName)?></span></div>
			</div>
			<nav class="mt-2">
				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
					<li class="nav-item"><a href="dashboard.php" class="nav-link <?=$active === 'dashboard' ? 'active' : ''?>"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
					<li class="nav-item"><a href="products.php" class="nav-link <?=$active === 'products' ? 'active' : ''?>"><i class="nav-icon fas fa-box"></i><p>Products</p></a></li>
					<li class="nav-item"><a href="categories.php" class="nav-link <?=$active === 'categories' ? 'active' : ''?>"><i class="nav-icon fas fa-tags"></i><p>Categories</p></a></li>
					<li class="nav-item"><a href="suppliers.php" class="nav-link <?=$active === 'suppliers' ? 'active' : ''?>"><i class="nav-icon fas fa-truck"></i><p>Suppliers</p></a></li>
					<li class="nav-item"><a href="sales.php" class="nav-link <?=$active === 'sales' ? 'active' : ''?>"><i class="nav-icon fas fa-cash-register"></i><p>Record Sale</p></a></li>
					<li class="nav-item"><a href="sales_history.php" class="nav-link <?=$active === 'history' ? 'active' : ''?>"><i class="nav-icon fas fa-receipt"></i><p>Sales History</p></a></li>
					<li class="nav-item"><a href="reports.php" class="nav-link <?=$active === 'reports' ? 'active' : ''?>"><i class="nav-icon fas fa-chart-bar"></i><p>Reports</p></a></li>
				</ul>
			</nav>
		</div>
	</aside>
	<div class="content-wrapper">
		<div class="content-header">
			<div class="container-fluid"><h1 class="m-0"><?=e($pageTitle)?></h1></div>
		</div>
		<section class="content">
			<div class="container-fluid">