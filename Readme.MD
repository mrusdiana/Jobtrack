<div align="center">

# 💼 Jobtrack

**A simple job application tracker, built twice — first in native PHP, then in Laravel — as a 7-day learning project for PHP, Laravel, and Docker.**

<br/>

<img src="https://img.shields.io/badge/🚧_Work_in_Progress-F59E0B?style=for-the-badge" alt="Work in progress"/>

<br/><br/>

<img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP"/>
<img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel"/>
<img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL"/>
<img src="https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker"/>
<img src="https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=composer&logoColor=white" alt="Composer"/>

</div>

---

## 📌 Overview

Jobtrack helps you keep track of the jobs you've applied to — add an application, view it, edit it, and delete it when it's no longer relevant.

The real goal is learning. The same app is built in two stages so the difference between "doing it by hand" and "using a framework" is easy to see:

1. **Native PHP (Day 1–4)** — plain PHP with PDO and MySQL, written from scratch.
2. **Laravel (Day 5–7)** — the same app rebuilt with Laravel's models, controllers, views, migrations, and tests.

Both stages can run locally or inside **Docker**.

> 🚧 This project is still in progress. Features and docs will keep changing as the 7-day plan moves forward.

---

## 🗺️ Learning Roadmap

| Day | Stage | Focus |
|-----|-------|-------|
| 1 | Native PHP | PHP basics as a CLI script |
| 2 | Native PHP | Form handling and validation (no database yet) |
| 3–4 | Native PHP | MySQL + PDO, full CRUD pages, Docker setup |
| 5–7 | Laravel | Rebuild with Laravel: models, controllers, views, migrations, seeders, tests, and Docker |

---

## ✨ Features

| Feature | Description |
|---------|-------------|
| 📋 **Application List** | See all your job applications in one place |
| ➕ **Add Application** | Form with input validation |
| 🔍 **Detail Page** | View a single application |
| ✏️ **Edit & Delete** | Update or remove an application |
| 🔐 **Login** *(Laravel)* | Demo account available after seeding |
| 🧪 **Tests** *(Laravel)* | Feature tests with `php artisan test` |
| 🐳 **Docker** | Run either stage with Docker Compose |

---

## 🛠️ Tech Stack

| Technology | Role |
|-----------|------|
| **PHP** | Native stage: plain PHP pages |
| **PDO** | Safe database access in the native stage |
| **Laravel** (PHP 8.2+) | Framework stage: MVC, migrations, seeders, tests |
| **MySQL** | Database |
| **Composer** | PHP dependency manager |
| **Docker** + **Docker Compose** | Containerized development |

---

## 🗂️ Project Structure

```
jobtrack/
├── GUIDE.md                  # Read first: development flow and how to use Docker
├── 1-native-php/             # Day 1–4: plain PHP + PDO + MySQL
│   ├── day1/index.php        #   CLI script (php day1/index.php)
│   ├── day2/create.php       #   Form + validation, no database yet
│   ├── config/database.php   #   PDO connection
│   ├── setup.sql             #   Creates the database and table
│   ├── index.php · create.php · show.php · edit.php · delete.php
│   └── Dockerfile · docker-compose.yml
│
└── 2-laravel/                # Day 5–7: Laravel
    ├── setup.sh              #   Creates a Laravel skeleton and applies overlay/
    └── overlay/              #   Jobtrack files: models, controllers, views,
                              #   migrations, tests, and Docker setup
```

---

## 🚀 Getting Started

### Option 1 — Native PHP (without Docker)
Requires PHP and MySQL (for example XAMPP or Laragon).

```bash
# 1. Run 1-native-php/setup.sql in MySQL
cd 1-native-php
php -S localhost:8000          # open http://localhost:8000
php day1/index.php             # Day 1 CLI script
```

### Option 2 — Native PHP (with Docker)
```bash
cd 1-native-php
docker compose up -d --build   # open http://localhost:8000
```

### Option 3 — Laravel
Requires PHP 8.2+ and Composer.

```bash
cd 2-laravel
bash setup.sh
cd jobtrack-laravel
php artisan serve              # open http://localhost:8000
php artisan test               # run the tests
```

**Demo login** (after seeding): `demo@jobtrack.test` / `password`

Running Laravel with Docker and more details are covered in **[GUIDE.md](GUIDE.md)**.

---
