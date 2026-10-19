<?php

function getenv_or_default(string $key, string $default): string
{
    $value = getenv($key);

    return $value === false || trim($value) === '' ? $default : $value;
}

$envPath = __DIR__ . '/../.env';
if (is_file($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) {
            continue;
        }

        [$name, $value] = array_pad(explode('=', $line, 2), 2, '');
        putenv(trim($name) . '=' . trim($value));
    }
}

return [
    'base_url' => getenv_or_default('APP_BASE_URL', '/school_management'),
    'db' => [
        'host' => getenv_or_default('DB_HOST', 'localhost'),
        'port' => getenv_or_default('DB_PORT', '3306'),
        'name' => getenv_or_default('DB_NAME', 'school_management'),
        'user' => getenv_or_default('DB_USER', 'root'),
        'password' => getenv_or_default('DB_PASSWORD', ''),
    ],
];
