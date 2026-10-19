SCHOOL MANAGEMENT SYSTEM - PHP + MySQL + XAMPP + AdminLTE 3

REQUIREMENTS
- XAMPP with Apache and MySQL running
- VS Code
- Browser and internet connection for AdminLTE CDN assets

INSTALLATION
1. Extract the folder "school_management_system" into:
   C:\xampp\htdocs\
   Final path should be C:\xampp\htdocs\school_management_system
2. Open XAMPP Control Panel and start Apache and MySQL.
3. Open http://localhost/phpmyadmin
4. Import database.sql (Import tab -> Choose File -> Go).
   The SQL creates the school_management database and its tables.
5. Open http://localhost/school_management_system/setup_admin.php once.
   It creates the first administrator account.
6. Login at http://localhost/school_management_system/login.php
   Username: admin
   Password: admin123
7. IMPORTANT: After successful setup, delete setup_admin.php.
8. Open http://localhost/school_management_system/

FILES
- config/db.php: PDO database connection
- includes/auth.php: login protection
- includes/header.php / footer.php: AdminLTE layout
- login.php / logout.php: authentication
- index.php: dashboard
- students.php: list, add, edit and delete students
- classes.php: list and add classes
- database.sql: database schema and starter classes

SECURITY / CLASSROOM PROJECT NOTES
- Change the starter password immediately for any real deployment.
- Do not deploy this classroom project publicly without stronger security review,
  HTTPS, backups, proper user management, and additional validation.
- AdminLTE assets are loaded from CDN, so internet is required for styling.
- XAMPP is intended for local development, not production hosting.
