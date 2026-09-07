# GitHub Hosting Guide

## Important
GitHub Pages does not execute PHP and does not provide MySQL. Therefore this PHP/MySQL CMS cannot be hosted as a working admin dashboard on GitHub Pages.

### Put the source code on GitHub
```bash
git init
git add .
git commit -m "Initial portfolio CMS"
git branch -M main
git remote add origin YOUR_REPOSITORY_URL
git push -u origin main
```

### For a working website
Host the PHP/MySQL project on a PHP-capable hosting service:
1. Create a MySQL database.
2. Import `database/schema.sql`.
3. Upload the project files.
4. Edit `config/config.php` with the host's database details.
5. Set `BASE_URL` to your live project URL/path.
6. Open `/admin/login.php`.
7. After setup, remove `admin/setup.php` if it is present.

### Security
Never commit production database passwords or other secrets to a public GitHub repository.
