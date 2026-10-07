# louxzz.net

A minimal, server-rendered PHP portfolio with a small authenticated project dashboard.

## requirements

- PHP 8.0 or newer with PDO MySQL
- MySQL or MariaDB
- Apache with `mod_rewrite` and `mod_headers` enabled

No package manager, JavaScript runtime, or build step is required.

## setup

1. Copy `config.php.example` to `config.local.php` and set the database credentials.
2. Import `database.sql` only for a new installation. Do not import it over production data.
3. Point the domain document root at this directory.
4. Ensure Apache allows `.htaccess` overrides (`AllowOverride All`).
5. Serve the production site over HTTPS.

`config.local.php` and `database.sql` are ignored by Git and denied by Apache. `config.php` contains only application helpers and safe environment-variable fallbacks.

## routes

- `/` — portfolio
- `/contact` — contact links
- `/dash` — dashboard or login redirect
- `/dash/projects/new` — create a project
- `/dash/projects/edit?id=1` — edit a project
- `/dash/projects/delete?id=1` — confirm project deletion

Legacy `/contacto.php` and `/admin/*.php` entry points redirect to the clean routes.

## data

Projects are always read from and written to the existing `projects` table. This redesign does not require a database migration.
