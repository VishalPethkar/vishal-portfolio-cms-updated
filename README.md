# Vishal Pethkar Portfolio CMS

A modern, editable PHP + MySQL admin dashboard built from the supplied static portfolio.

## Features

- Secure admin login with `password_hash()`
- Dashboard overview
- Edit hero/site settings, contact details, social links, profile photo and resume
- Add/edit/delete skills, projects, experience, education, certificates and services
- Hide/show any item without deleting it
- Reorder items with saved order values
- Image uploads
- Contact form stores messages in MySQL
- Responsive modern portfolio frontend
- Dark/light theme toggle
- No framework required

## Requirements

- XAMPP/WAMP/LAMP
- PHP 8.0+
- MySQL/MariaDB
- Apache with PHP enabled

## Installation

1. Extract this folder into your web server directory, e.g. `C:\xampp\htdocs\vishal-portfolio-cms`.
2. Start Apache and MySQL in XAMPP.
3. If you use a different folder name, update `BASE_URL` in `config/config.php`.
4. Open `http://localhost/vishal-portfolio-cms/admin/setup.php`.
5. Create your own admin email and password.
6. Sign in at `/admin/login.php`.
7. **Delete `admin/setup.php` after installation.**
8. Open `/` to view the portfolio.

## Database

The setup page imports `database/schema.sql`. If your hosting does not allow PHP to create databases, create the database `vishal_portfolio` manually in phpMyAdmin, select it, import `database/schema.sql`, and then update `config/config.php`.

## Important security notes

- Change the default/temporary admin password immediately.
- Do not publish `config/config.php` or database credentials.
- Keep `admin/setup.php` deleted after installation.
- Use HTTPS when deployed online.
- Restrict upload types and maximum upload sizes on production hosting.

## Editing workflow

Admin → Site Settings controls the hero/contact/social information.

Admin → Skills/Projects/Experience/etc. controls individual content records. Each item can be edited, hidden/shown, deleted, and reordered.

The public site reads the database on every request, so changes appear without editing HTML source code.


## Admin credentials
The supplied installation is configured with the requested admin email:
`riteshpethkar1001@gmail.com`

The requested password is stored only as a PHP `password_hash()` bcrypt hash in the database schema. Do not publish or share the password in your repository.

## Important: GitHub Pages
This project is PHP + MySQL, so **GitHub Pages cannot run the admin dashboard, PHP, or MySQL database**.

You have two practical choices:

### Option A — GitHub Pages (portfolio frontend only)
Use this only if you convert/export the portfolio to static HTML/CSS/JS. GitHub Pages can serve static files, but the PHP admin CMS will not work there.

### Option B — Full portfolio + live admin dashboard
Use a PHP/MySQL hosting provider (shared hosting or a VPS). Upload the whole `vishal-portfolio-cms` folder, create the MySQL database, update `config/config.php`, import `database/schema.sql`, and open `/admin/login.php`.

For GitHub, you can still use a GitHub repository to store the source code, while the live PHP site runs on PHP/MySQL hosting.

### GitHub repository upload
1. Create a new repository on GitHub, e.g. `vishal-portfolio-cms`.
2. Extract this ZIP.
3. Open the extracted project folder in VS Code.
4. Initialize Git and push the project:
   - `git init`
   - `git add .`
   - `git commit -m "Initial portfolio CMS"`
   - `git branch -M main`
   - `git remote add origin YOUR_GITHUB_REPOSITORY_URL`
   - `git push -u origin main`
5. Do **not** put real database passwords, API keys, or other secrets into GitHub.

### If you want a GitHub-only live portfolio
Ask for a **static GitHub Pages version** of this portfolio. The live admin/database features must then be replaced by a service that supports authentication/data storage, or hosted separately.
