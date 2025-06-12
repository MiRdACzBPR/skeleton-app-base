Features
==================

✅ Skeleton application using the latest [Nette](https://nette.org) framework and 
[Latte](https://latte.nette.org) templating engine, fully compatible with [PHP](https://www.php.net) 8.1 and newer.

🔐 User registration and login system (with DB table `users`)

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
```
🧰 Core Nette components:
`nette/application`, `nette/forms`, `nette/database`, `nette/security`, `nette/http`, `nette/utils`

🛠 Debugging with [Tracy](https://tracy.nette.org/)

🌍 Translation support via [contributte/translation](https://contributte.org/packages/contributte/translation.html#content)

🧾 Bootstrap-form integration using [contributte/forms-bootstrap](https://contributte.org/packages/contributte/forms-bootstrap.html)

🎨 Templating with [Latte](https://latte.nette.org)

📦 Composer-ready installation:
```bash
composer create-project mirdaczbpr/skeleton-app-base MiRdACz-BPR
```

🚀 Quick start using built-in PHP server:
```bash
php -S localhost:8000 -t www
```

🔐 Security best practices: Protect `app/`, `config/`, `log/`, and `temp/` folders from web access

🧪 Basic testing setup using [nette/tester](https://tester.nette.org/)

🗂 Project structure prepared for MVC and further expansion
