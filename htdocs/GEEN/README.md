# GEEN School Management System

A PHP and MySQL school management application for administrators, teachers, staff, and parents.

## Target stack

- PHP 8.1+
- MySQL 8 / MariaDB
- Apache via XAMPP
- HTML5, CSS3, and JavaScript
- mysqli

## Project structure

- `admin/` — user management
- `attendance/` — attendance records
- `classes/` — class records
- `config/` — application and database configuration
- `css/` — shared styles
- `fees/` — fee records
- `includes/` — shared layout
- `results/` — academic results
- `students/` — student records
- `subjects/` — subject records
- `teachers/` — teacher records
- `tests/` — project tests

## Setup

1. Copy `.env.example` to `.env`.
2. Update the database settings in `.env`.
3. Import `database/schema.sql` into MySQL.
4. Start Apache and MySQL in XAMPP.
5. Open the project through the Apache document root.

The application expects the database name `school_management` by default.

## Run checks

```bash
php tests/project_test.php
php tests/syntax_test.php
```

## Development

```bash
composer install
composer test
composer lint
```

> The included tests validate the project structure, shared database configuration, and PHP syntax. They do not connect to MySQL.
