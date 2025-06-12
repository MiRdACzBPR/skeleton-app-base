Skeleton web project in Nette
==================

Welcome this is the basic skeleton of an application built with
[Nette](https://nette.org), a new framework for developing our web projects.

If you find Nette helpful, please consider supporting her with a [donation](https://nette.org/donate).
Thank you for your generosity!


Requirements
------------
This Web Project is compatible with Nette 3.2 and requires PHP 8.1.


Installation
------------

To install the Web Project, Composer is the recommended tool. If you're new to Composer,
follow [these instructions](https://doc.nette.org/composer). Then, run:

	composer create-project mirdaczbpr/skeleton-app-base skeleton-app-base

Ensure the `temp/` and `log/` directories are writable.


Web Server Setup
----------------

To quickly dive in, use PHP's built-in server:

	php -S localhost:8000 -t www

Then, open `http://localhost:8000` in your browser to view the welcome page.

For Apache or Nginx users, configure a virtual host pointing to your project's `www/` directory.

**Important Note:** Ensure `app/`, `config/`, `log/`, and `temp/` directories are not web-accessible.
Refer to [security warning](https://nette.org/security-warning) for more details.