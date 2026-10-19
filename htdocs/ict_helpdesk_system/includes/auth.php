<?php
declare(strict_types=1);
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once __DIR__ . '/../config/database.php';

function e($value): string {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}
function current_user(): ?array {
    return $_SESSION['user'] ?? null;
}
function require_login(): void {
    if (!current_user()) {
        header('Location: /ict_helpdesk_system/login.php');
        exit;
    }
}
function require_role(array $roles): void {
    require_login();
    if (!in_array(current_user()['role'], $roles, true)) {
        http_response_code(403);
        exit('403 Forbidden: you do not have permission to access this page.');
    }
}
function is_staff(): bool {
    return current_user() && in_array(current_user()['role'], ['admin','technician'], true);
}
function ticket_visible_sql(): string {
    if (!current_user()) return '1=0';
    if (current_user()['role'] === 'admin') return '1=1';
    if (current_user()['role'] === 'technician') return '(t.technician_id = ' . (int)current_user()['id'] . ' OR t.technician_id IS NULL)';
    return 't.user_id = ' . (int)current_user()['id'];
}
