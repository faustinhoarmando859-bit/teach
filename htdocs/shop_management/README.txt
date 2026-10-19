SHOP MANAGEMENT SYSTEM — PHP + MySQL + AdminLTE 3

FEATURES
- AdminLTE 3 dashboard with product/category/supplier counts, today's sales, low-stock alert and recent sales
- Product CRUD (SKU, cost price, selling price, stock, reorder level, category, supplier)
- Category CRUD
- Supplier CRUD
- Record sales with stock validation and automatic stock deduction in a database transaction
- Sales history with detail modals
- Date-filtered sales report and print button
- Login/logout, password hashing, prepared statements

INSTALLATION (XAMPP / Windows)
1. Extract the shop_management folder into C:\xampp\htdocs\
2. Start Apache and MySQL in XAMPP Control Panel.
3. Open http://localhost/phpmyadmin
4. Import database.sql (choose the file from the extracted project).
5. Open http://localhost/shop_management/setup_admin.php ONCE to create the first administrator account.
6. Sign in at http://localhost/shop_management/login.php
   Username: admin
   Password: admin123
7. IMPORTANT: delete setup_admin.php after the account is created.
8. AdminLTE 3 and libraries are loaded from CDNs, so the browser needs internet access for the styling/scripts.

DATABASE TABLES
users, categories, suppliers, products, sales, sale_items.
Relationships: categories 1-to-many products; suppliers 1-to-many products; users 1-to-many sales; sales 1-to-many sale_items; products 1-to-many sale_items.

ADMINLTE COMPONENTS USED (assignment requirement)
1. Small Boxes — dashboard summaries
2. Sidebar Navigation Menu — app navigation
3. Breadcrumbs — page location
4. Responsive Tables — products/categories/suppliers/sales
5. Badges — low-stock/in-stock state
6. Forms and Input Groups — product/category/supplier/sale forms and login
7. Alerts — success/error feedback
8. Modals — sale details
9. Callouts — sale workflow guidance
10. Info Boxes — report summaries
11. Buttons/Button Groups — CRUD and actions

NOTES
- This is a beginner-friendly local demo. Use a strong password and additional production hardening before deployment online.
- Product quantities are updated by recording sales. Editing a product's quantity is available for initial stock/stock corrections.
- AdminLTE CDN dependencies require internet. For a fully offline setup, replace CDN links with the matching local AdminLTE dist and plugins files.
