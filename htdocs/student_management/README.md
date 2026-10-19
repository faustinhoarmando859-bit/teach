# Student Management System

This is a simple PHP and MySQL based Student Management System that allows users to manage student records. The system provides functionalities to add, view, edit, and delete student information.

## Project Structure

```
student-management-system
├── connection.php       # Establishes a connection to the MySQL database
├── form.php             # Main interface for student management
├── process.php          # Handles data management operations
├── database
│   └── schema.sql       # SQL schema for creating the database and tables
├── assets
│   └── css
│       └── style.css     # CSS styles for the application
└── README.md            # Project documentation
```

## Files Description

- **connection.php**: This file establishes a connection to the MySQL database using `mysqli`. It connects to the database named "data-submission" with the specified credentials and handles connection errors.

- **form.php**: This file serves as the main interface for the Student Management System. It contains a registration form for adding new students and displays all existing student records in a table format. Each record includes options to view, edit, or delete the student.

- **process.php**: This file handles all operations related to student data management. It processes form submissions for inserting new records, viewing student details, editing existing records, updating student information, and deleting records from the database.

- **database/schema.sql**: This file contains the SQL commands to create the necessary database and tables for the application.

- **assets/css/style.css**: This file contains the CSS styles used in the application to enhance the user interface.

## Getting Started

1. **Setup Database**: 
   - Create a MySQL database named `data-submission`.
   - Run the SQL commands in `database/schema.sql` to create the necessary tables.

2. **Configuration**: 
   - Update the database connection details in `connection.php` if necessary.

3. **Run the Application**: 
   - Place the project files in your web server's document root (e.g., `htdocs` for XAMPP).
   - Access the application via your web browser at `http://localhost/student-management-system/form.php`.

## Features

- Add new student records.
- View details of existing students.
- Edit student information.
- Delete student records.
- Responsive design for better user experience.

## License

This project is open-source and available for modification and distribution.