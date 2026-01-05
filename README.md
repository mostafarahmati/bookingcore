<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

# BookingCore - Event Booking System

A simple event reservation system built with **Laravel 11**.

## What the Reservation Service Does

Users can:

- Register and login
- View the list of events and event details
- Book an event (if there is capacity and they have not booked it before)
- Cancel their own booking

The system checks the real capacity of each event and race condition.












## Important Links

- **Admin Panel (Filament)**: http://localhost/admin  
  (For managing users, events, and reservations)








- **API Documentation (Swagger)**: http://localhost/api/documentation  
  (Interactive docs - use Bearer token for protected endpoints)




- **Base API URL**: http://localhost/api

- **Live Tests Page**: http://localhost/test/reservation-service  
  (Run and view tests online)

## How to Install on Local (with Docker - Laravel Sail)

```bash
# 1. Clone the project
git clone https://github.com/mostafarahmati/bookingcore.git
cd bookingcore

# 2. Copy environment file
cp .env.example .env


# 3. Install dependencies
composer install --ignore-platform-reqs

# 4. Start containers
./vendor/bin/sail up -d

# 5. Generate app key
./vendor/bin/sail artisan key:generate

# 6. Run database migrations
./vendor/bin/sail artisan migrate

# 7. Create admin user for panel
./vendor/bin/sail artisan make:filament-user
# Enter email and password

# 8. Generate Swagger docs
./vendor/bin/sail artisan l5-swagger:generate
```








## How to Install on Server (without Docker)

```bash
git clone https://github.com/mostafarahmati/bookingcore.git
cd bookingcore

composer install
cp .env.example .env
php artisan key:generate

# Set database details in .env
php artisan migrate

# Create admin user
php artisan make:filament-user

php artisan l5-swagger:generate
```

Point your web server (Nginx or Apache) to the `public` folder.

## Run Tests

```bash
./vendor/bin/sail artisan test    # On local with Sail
# or
php artisan test                  # On server
```

## Useful Commands

```bash
./vendor/bin/sail shell    # Enter container
./vendor/bin/sail logs     # View logs
./vendor/bin/sail down     # Stop containers
```

If you have problems, email: mostafarahmati@outlook.com

License: MIT
