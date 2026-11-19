# ISProject1

A small PHP and MySQL web app with user registration and login, hosted on an Azure VM and served over HTTPS.

Live site: https://malcolmpritpalproject.me
Subdomains: www, app (application page), api (JSON status endpoint)

## Stack
- Ubuntu on Microsoft Azure, Apache, PHP, MySQL
- DNS on Namecheap
- TLS certificate from ZeroSSL

## Who did what

Pritpal
- Azure VM, static IP and firewall rules
- DNS records and subdomains
- Apache virtual hosts
- Nightly database backup (cron job)

Malcolm
- ZeroSSL certificate, HTTPS and HTTP-to-HTTPS redirect
- Password hashing and prepared statements
- Client-side and server-side input validation
- Login rate limiting

## Repository layout
- `register.php`, `login.php`, `dashboard.php`, `logout.php`: pages
- `register_process.php`, `login_process.php`: form handling
- `db.php`: database connection (reads `config.php`)
- `config.sample.php`: template for the database settings
- `infra/`: backup script and Apache virtual host files

## Setup
1. Create the `isproject1` database and the `users` table.
2. Copy `config.sample.php` to `config.php` and fill in the database password. `config.php` is not tracked by Git.
3. Point an Apache virtual host at the project folder.

## Backups
`infra/backup_isproject1.sh` dumps the database with `mysqldump`, compresses it and saves it to `/var/backups/isproject1/` with the date in the filename. Cron runs it daily at 02:00.
