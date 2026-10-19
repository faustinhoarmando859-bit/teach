<?php

declare(strict_types=1);

$projectRoot = dirname(__DIR__);
$files = [];

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($projectRoot, FilesystemIterator::SKIP_DOTS)
);

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $files[] = $file->getPathname();
    }
}

$failures = [];

foreach ($files as $file) {
    $output = [];
    $exitCode = 0;
    exec('php -l ' . escapeshellarg($file) . ' 2>&1', $output, $exitCode);

    if ($exitCode !== 0) {
        $failures[] = $file . ': ' . implode(' ', $output);
    }
}

if ($failures !== []) {
    foreach ($failures as $failure) {
        fwrite(STDERR, "FAIL: {$failure}\n");
    }
    exit(1);
}

echo 'PASS: all PHP files have valid syntax.' . PHP_EOL;
