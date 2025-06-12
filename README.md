Skeleton web project in Nette
==================

Welcome! This is the basic skeleton of an application built with
[Nette](https://nette.org), a framework for developing modern web projects.

If you find Nette helpful, please consider supporting it with a [donation](https://nette.org/donate).
Thank you for your generosity!

Requirements
------------
This Web Project is compatible with **Nette 3.2** and requires **PHP 8.1+**.

Installation
------------
To install the Web Project, Composer is the recommended tool. If you're new to Composer,
follow [these instructions](https://doc.nette.org/composer). Then, run:

	composer create-project mirdaczbpr/skeleton-app-base skeleton-app-base

Ensure the `temp/` and `log/` directories are writable.

It is necessary to insert the `users` table into the database:

```sql
CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `active_key` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci DEFAULT NULL,
  `authtoken` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB CHARSET=utf8;

Features
✅ Skeleton application based on Nette 3.2, ready for PHP 8.1+

🔐 User registration and login system (with DB table users)

🧰 Core Nette components:

nette/application, nette/forms, nette/database, nette/security, nette/http, nette/utils

🛠 Debugging with Tracy

🌍 Translation support via contributte/translation

🧾 Bootstrap-form integration using contributte/forms-bootstrap

🎨 Latte templating engine

📦 Composer-ready installation

🚀 Quick start using built-in PHP server:

bash
Zkopírovat
Upravit
php -S localhost:8000 -t www
🔐 Security best practices:

Protect app/, config/, log/, and temp/ folders from web access

🧪 Basic testing setup using nette/tester

🗂 Project structure prepared for MVC and further expansion

Web Server Setup
To quickly dive in, use PHP's built-in server:

nginx
Zkopírovat
Upravit
php -S localhost:8000 -t www
Then, open http://localhost:8000 in your browser to view the welcome page.

For Apache or Nginx users, configure a virtual host pointing to your project's www/ directory.

Important Note: Ensure app/, config/, log/, and temp/ directories are not web-accessible.
Refer to security warning for more details.
