Skeleton Web Project in Nette
=============================

Welcome! This is a basic skeleton of a modern web application built with the 
[Nette](https://nette.org) framework and the [Latte](https://latte.nette.org) templating engine.  
If you find Nette helpful, please consider supporting it via a [donation](https://nette.org/donate).  
Thank you for your generosity!

Requirements
------------

- [PHP](https://www.php.net) 8.1 or newer
- [Composer](https://getcomposer.org)
- Compatible with [Nette](https://nette.org) 3.2+

Installation
------------

To install the application, use Composer:

```bash
composer create-project mirdaczbpr/skeleton-app-base skeleton-app-base
```

Make sure the following folders are writable:

- `temp/`
- `log/`

Database Setup
--------------

Before running the app, insert the `users` table into your database:

```sql
CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` varchar(30) COLLATE utf8mb4_czech_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `active_key` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci DEFAULT NULL,
  `authtoken` varchar(128) COLLATE utf8mb4_czech_ci NOT NULL,
  `ip` varchar(45) COLLATE utf8mb4_czech_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;
```

Web Server Setup
----------------

To quickly run the app with PHP’s built-in server:

```bash
php -S localhost:8000 -t www
```

Then open `http://localhost:8000` in your browser.

If you use Apache or Nginx, configure your virtual host to point to the `www/` directory.

⚠️ **Important:** Protect the following folders from public web access:  
`app/`, `config/`, `log/`, and `temp/`

Features
========

✅ Skeleton application using the latest [Nette](https://nette.org) framework and 
[Latte](https://latte.nette.org) templating engine, fully compatible with [PHP](https://www.php.net) 8.1 and newer.

🔐 User registration and login system (with DB table `users`)

🧰 Core Nette components:
- `nette/application`
- `nette/forms`
- `nette/database`
- `nette/security`
- `nette/http`
- `nette/utils`

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

🔐 Security best practices:  
Protect `app/`, `config/`, `log/`, and `temp/` folders from web access

🧪 Basic testing setup using [nette/tester](https://tester.nette.org/)

🗂 Project structure prepared for MVC and further expansion

--------------

Skeleton webový projekt v Nette
=============================

Vítejte! Toto je základní kostra moderní webové aplikace postavené na frameworku 
[Nette](https://nette.org) a šablonovacím systému [Latte](https://latte.nette.org).  
Pokud vám Nette pomáhá, zvažte prosím jeho [podporu formou daru](https://nette.org/donate).  
Děkujeme za vaši štědrost!

Požadavky
---------

- [PHP](https://www.php.net) verze 8.1 nebo novější
- [Composer](https://getcomposer.org)
- Kompatibilní s [Nette](https://nette.org) 3.2+

Instalace
---------

Pro instalaci aplikace použijte Composer:

```bash
composer create-project mirdaczbpr/skeleton-app-base skeleton-app-base
```

Ujistěte se, že následující složky mají povolený zápis:

- `temp/`
- `log/`

Nastavení databáze
------------------

Před spuštěním aplikace je potřeba do databáze vložit tabulku `users`:

```sql
CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` varchar(30) COLLATE utf8mb4_czech_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `active_key` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci DEFAULT NULL,
  `authtoken` varchar(128) COLLATE utf8mb4_czech_ci NOT NULL,
  `ip` varchar(45) COLLATE utf8mb4_czech_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;
```

Spuštění webového serveru
--------------------------

Pro rychlé spuštění aplikace pomocí vestavěného PHP serveru spusťte:

```bash
php -S localhost:8000 -t www
```

Poté otevřete ve svém prohlížeči adresu `http://localhost:8000`.

Používáte-li Apache nebo Nginx, nastavte virtuální hostitel tak, aby směřoval do složky `www/`.

⚠️ **Důležité:** Zabezpečte tyto složky proti přímému přístupu z webu:  
`app/`, `config/`, `log/`, `temp/`

Funkce projektu
===============

✅ Aplikace postavená na nejnovějším [Nette](https://nette.org) frameworku a šablonovacím systému 
[Latte](https://latte.nette.org), plně kompatibilní s [PHP](https://www.php.net) 8.1+

🔐 Registrace a přihlášení uživatelů (pomocí tabulky `users`)

🧰 Klíčové komponenty Nette:
- `nette/application`
- `nette/forms`
- `nette/database`
- `nette/security`
- `nette/http`
- `nette/utils`

🛠 Ladění pomocí [Tracy](https://tracy.nette.org/)

🌍 Podpora překladů přes [contributte/translation](https://contributte.org/packages/contributte/translation.html#content)

🧾 Integrace Bootstrap formulářů přes [contributte/forms-bootstrap](https://contributte.org/packages/contributte/forms-bootstrap.html)

🎨 Šablonování pomocí [Latte](https://latte.nette.org)

📦 Instalace přes Composer:

```bash
composer create-project mirdaczbpr/skeleton-app-base MiRdACz-BPR
```

🚀 Rychlé spuštění pomocí vestavěného PHP serveru:

```bash
php -S localhost:8000 -t www
```

🔐 Bezpečnostní doporučení:  
Zajistěte, aby složky `app/`, `config/`, `log/` a `temp/` nebyly dostupné z webu

🧪 Základní nastavení testování pomocí [nette/tester](https://tester.nette.org/)

🗂 Struktura projektu připravena pro MVC a další rozšíření

