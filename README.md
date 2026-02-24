# Task App — Quick Start

For people who clone the repository
- Clone and enter repository:
  ```bash
  git clone <repo-url> task-app
  cd task-app
  ```
- Install PHP deps and frontend deps:
  ```bash
  composer install
  npm install
  ```
- Copy example env and set DB credentials (edit .env):
  ```bash
  cp .env.example .env    # or: copy .env.example .env on Windows
  # edit DB_* values in .env as needed
  ```
- Generate app key and run migrations:
  ```bash
  php artisan key:generate
  php artisan migrate
  ```
- Build assets (dev) and run:
  ```bash
  npm run dev
  php artisan serve --host=127.0.0.1 --port=8000
  ```
- Open: http://127.0.0.1:8000/tasks

Minimal instructions for running the project distributed as a zip (includes .env)

Prerequisites
- PHP 8.x (8.5 originally), Composer
- MySQL / MariaDB (or other supported DB)
- Node.js + npm

Quick start
1. Unpack and open project:
   `cd path/to/task-app`

2. Install PHP deps:
   `composer install`

3. If APP_KEY is empty in .env, generate it:
   `php artisan key:generate`

4. Change database credentials
   - Edit DB_* values in `.env` (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD).
   - Then run:
     `php artisan config:clear`
     `php artisan cache:clear`

5. Run migrations:
   `php artisan migrate`

6. Install frontend deps and build assets:
   `npm install`
   `npm run dev`

7. Run local server:
   `php artisan serve --host=127.0.0.1 --port=8000`
   Open: http://127.0.0.1:8000/tasks

Notes
- If the zip includes a ready `.env`, verify credentials before running migrations.
- Avoid committing sensitive credentials to public repositories.
