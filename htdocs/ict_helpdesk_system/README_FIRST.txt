ICT HELPDESK & EQUIPMENT MANAGEMENT SYSTEM
==========================================

STACK
- PHP 8+ (works with XAMPP)
- MySQL/MariaDB
- AdminLTE 3 interface (loaded from CDN)
- PDO prepared statements for database access

QUICK START (XAMPP)
1. Extract the folder "ict_helpdesk_system" into:
   C:\xampp\htdocs\
   Final folder should be C:\xampp\htdocs\ict_helpdesk_system\

2. Open XAMPP Control Panel and start Apache and MySQL.

3. Open http://localhost/phpmyadmin
   Create/import the database by selecting Import and choosing database.sql.
   (The SQL file creates the database automatically if your MySQL user has permission.
   If it does not, create a database named ict_helpdesk and import the file.)

4. Check config/database.php:
   Default XAMPP settings are host=127.0.0.1, user=root, password empty.
   Change them if your MySQL account uses a password.

5. Visit:
   http://localhost/ict_helpdesk_system/setup_admin.php
   This creates the first administrator account:
   Email: admin@icthelpdesk.local
   Password: Admin@123

6. Log in at:
   http://localhost/ict_helpdesk_system/login.php

7. IMPORTANT SECURITY STEP:
   After setup_admin.php reports success, DELETE setup_admin.php from the project folder.
   Change the default admin password as soon as possible (the starter project does not yet
   include a password-change page; you can update it by registering a new admin through SQL
   or ask me to add the feature next).

DEMO WORKFLOW
- Register a normal user at register.php.
- Sign in as admin and create equipment.
- User submits a ticket.
- Admin assigns the ticket to a technician (create a technician account by changing that
  user's role to technician in phpMyAdmin, or ask me to add technician/user management).
- Technician/admin updates ticket status and records a solution.

CURRENT FEATURES
- Login/logout with hashed passwords
- User registration
- Role-based access (admin, technician, user)
- AdminLTE sidebar/dashboard
- Create and view helpdesk tickets
- Assign tickets to technicians (admin/technician access)
- Update ticket status and add resolution notes
- Equipment inventory listing and adding equipment (admin/technician)
- Ticket status/category summaries
- SQL schema and starter categories

NOTE
This is a runnable starter system for learning and demonstration. Before using it in a real
institution, add CSRF protection, rate limiting, password reset/change, email notifications,
audit logging, stronger validation, backups, and production HTTPS settings. AdminLTE and
other front-end assets load from CDNs, so internet access is needed for the styling.
