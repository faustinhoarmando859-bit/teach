<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/app.php';

$projectRoot = dirname(__DIR__);
$requiredFiles = [
    'config/database.php',
    'config/app.php',
    'database/schema.sql',
    'README.md',
    '.env.example',
];

$requiredPages = [
    'index.php',
    'login.php',
    'register.php',
    'dashboard.php',
    'students/index.php',
    'teachers/index.php',
    'classes/index.php',
    'subjects/index.php',
    'results/index.php',
    'attendance/index.php',
    'fees/index.php',
];

$failures = [];

foreach ($requiredFiles as $file) {
    if (!is_file($projectRoot . '/' . $file)) {
        $failures[] = "Missing required file: {$file}";
    }
}

foreach ($requiredPages as $page) {
    $path = $projectRoot . '/' . $page;
    if (!is_file($path)) {
        $failures[] = "Missing required page: {$page}";
        continue;
    }

    $content = file_get_contents($path);
    if ($content === false || !str_contains($content, 'config/database.php')) {
        $failures[] = "Page does not use the shared database configuration: {$page}";
    }
}

if ($failures !== []) {
    foreach ($failures as $failure) {
        fwrite(STDERR, "FAIL: {$failure}\n");
    }
    exit(1);
}

echo "PASS: project foundation and required pages are present.\n";
