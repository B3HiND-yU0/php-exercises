# PHP Basics - Hands-on Exercises

## Setup (XAMPP / Laragon)
1. Copy the `php-exercises` folder into `htdocs` (XAMPP) or `www` (Laragon).
2. Start Apache and MySQL.
3. Open phpMyAdmin -> Import -> choose `database/php_exercises.sql` (creates the `php_exercises` database and tables).
4. If your MySQL has a password, edit `config/database.php`.
5. Visit http://localhost/php-exercises/

## Folders
- output1/    Form with Age, Gender, Email, Address, Contact Number + validation
- output2/    Home, Register, Login, Forgot Password using include/require
- output3-4/  Same form saved to MySQL, with list below (search / edit / delete)
- output5/    Faculty CRUD following MVC (models / views / controllers)
- database/   Exported .sql file
