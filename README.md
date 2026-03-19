# Dota2 Draft Planner API

A dedicated backend API for managing Dota 2 draft planning scenarios (bans, preferred picks, and enemy threats), built with **Laravel** and **PostgreSQL**.

This project is packaged using **Docker Compose** and includes a **single command** to initialize and populate the database (**migrate + seed**), as required.

---

# Tech Stack

- **Backend**: Laravel (PHP)
- **Database**: PostgreSQL
- **Containerization**: Docker + Docker Compose

---

# Features

- Dockerized backend API service
- PostgreSQL database service
- One-command database initialization (`migrate + seed`)
- Supports:
  - **Docker PostgreSQL**
  - **External PostgreSQL** (via environment configuration)

---

# Requirements

Please make sure you have installed:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)  
  (usually included in modern Docker installations)

Optional (for convenience):
- `make`

---

# Project Structure

```bash
.
├── app/
├── bootstrap/
├── config/
├── database/
├── docker/
│   └── php/
│       └── Dockerfile
├── routes/
├── docker-compose.yml
├── Makefile
└── README.md
```

---

# Quick Start (Using Docker PostgreSQL)

This is the default and recommended setup.

## 1. Clone the repository

```bash
git clone git@github.com:CevinWays/dota2_draft_plan_be.git
cd dota2_draft_plan_be
```

---

## 2. Prepare environment file

Copy the example environment file:

```bash
cp .env.example .env
```

Make sure the database configuration uses the Docker PostgreSQL service:

```env
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=dota2_draft_planner
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

---

## 3. Start containers

Using Makefile (recommended):

```bash
make up
```

Or directly with Docker Compose:

```bash
docker compose up -d --build
```

---

## 4. Generate application key (if needed)

If `APP_KEY` is not already set in `.env`:

```bash
docker compose exec app php artisan key:generate
```

---

## 5. Initialize and populate the database (**required one-command setup**)

This project provides a dedicated command to initialize the database:

```bash
docker compose exec app php artisan app:init
```

This command will:

- Wait until the database is reachable
- Run migrations
- Run seeders

### Optional (with Makefile)

```bash
make init
```

---

## 6. Access the API

Once the containers are running:

```bash
http://localhost:8000
```

---

# One-Command Database Initialization

To satisfy the requirement:

> One command to initialize and populate the local database (migrate + seed)

Use:

```bash
docker compose exec app php artisan app:init
```

This works regardless of whether the application connects to:

- the included Docker PostgreSQL service, or
- an external PostgreSQL instance,

as long as the `.env` database configuration points to a reachable PostgreSQL host.

---

# Using External PostgreSQL

This project also supports connecting the API container to an external PostgreSQL instance instead of the included Docker PostgreSQL service.

## Example:

Update `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=host.docker.internal
DB_PORT=54322
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

> Note: `host.docker.internal` is enabled in `docker-compose.yml` for host access from the container.

Then start the application container as usual:

```bash
docker compose up -d --build
```

Run the **same initialization command**:

```bash
docker compose exec app php artisan app:init
```

✅ Same command, different database target via environment configuration.

---

# Useful Commands

## Start containers

```bash
make up
```

or

```bash
docker compose up -d --build
```

---

## Stop containers

```bash
make down
```

or

```bash
docker compose down
```

---

## Restart containers

```bash
make restart
```

---

## View logs

```bash
make logs
```

---

## Open shell inside app container

```bash
make bash
```

---

## Run migrations only

```bash
make migrate
```

---

## Run seeders only

```bash
make seed
```

---

## Rebuild database from scratch

```bash
make fresh
```

Equivalent to:

```bash
docker compose exec app php artisan migrate:fresh --seed
```

---

# Docker Services

## `app`
Laravel API service.

- Built from: `docker/php/Dockerfile`
- Exposes: `8000`

Runs the application using Laravel’s built-in development server:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

---

## `postgres`
PostgreSQL database service.

- Image: `postgres:16-alpine`
- Exposes: `5432`

Default credentials:

- **Database**: `dota2_draft_planner`
- **Username**: `postgres`
- **Password**: `postgres`

---

# Custom Artisan Command

This project includes a dedicated artisan command:

```bash
php artisan app:init
```

## Purpose

Initialize the application database in a single command.

## Behavior

- Waits for PostgreSQL to become available
- Runs:
  - `php artisan migrate`
  - `php artisan db:seed`

## Optional fresh mode

```bash
php artisan app:init --fresh
```

This will run:

- `php artisan migrate:fresh --seed`

---

# API Base URL

```bash
http://localhost:8000/api
```

---

# Notes

- Redis is intentionally not included to keep the setup minimal and focused on the required scope.
- Nginx is intentionally not included; the Laravel built-in server is sufficient for local evaluation and demo purposes.
- The included PostgreSQL service is the default option, but the application can also connect to an external PostgreSQL instance by updating `.env`.

---

# Troubleshooting

## Application container starts but API is not accessible

Check logs:

```bash
docker compose logs -f app
```

---

## Database connection error

Verify that `.env` is configured correctly.

### For Docker PostgreSQL:

```env
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=dota2_draft_planner
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

### For external PostgreSQL :

```env
DB_HOST=host.docker.internal
DB_PORT=<your-port>
DB_DATABASE=<your-db-name>
DB_USERNAME=<your-username>
DB_PASSWORD=<your-password>
```

Then rerun:

```bash
docker compose exec app php artisan app:init
```

---

## `APP_KEY` missing

Generate it:

```bash
docker compose exec app php artisan key:generate
```

---

# Submission Notes

This project was designed to explicitly satisfy the following requirements:

- Dedicated backend API service
- PostgreSQL database
- Docker Compose packaging
- One-command local database initialization and population (`migrate + seed`)
- Compatibility with either:
  - Docker PostgreSQL
  - external PostgreSQL

The main initialization command is:

```bash
docker compose exec app php artisan app:init
```

---

# Author

**Cevin Ways**