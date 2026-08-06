# Foogra — Restaurant Directory

A restaurant discovery and booking platform built with Laravel 13. Users can browse restaurants, make bookings, leave reviews, and submit their own restaurants for approval.

## Requirements

- PHP 8.4+
- Composer
- MySQL 8.0+
- A local server (Laragon, XAMPP, or standalone MySQL)

## Installation

**1. Clone the repository**
```bash
git clone <repo-url>
cd restaurants
```

**2. Install dependencies**
```bash
composer install
```

**3. Set up environment**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Configure your database**

Open `.env` and update the database credentials:
```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=restaurants
DB_USERNAME=root
DB_PASSWORD=
```

**5. Create the database**

In MySQL, run:
```sql
CREATE DATABASE restaurants;
```

**6. Run migrations and seed**
```bash
php artisan migrate --seed
```

**7. Link storage**
```bash
php artisan storage:link
```

**8. Start the server**
```bash
php artisan serve
```

Visit `http://localhost:8000`

## Default Accounts

| Role  | Email             | Password |
|-------|-------------------|----------|
| Admin | admin@foogra.com  | password |

## Features

- Browse and search restaurants with filters (category, cuisine, rating, price)
- Table booking system
- Review system (only for users with confirmed bookings)
- Restaurant submission by users (pending admin approval)
- Admin panel for managing restaurants, bookings and reviews
