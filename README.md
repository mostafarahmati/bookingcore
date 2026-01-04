<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/your-username/booking-service/actions"><img src="https://github.com/your-username/booking-service/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://github.com/your-username/booking-service"><img src="https://img.shields.io/github/stars/your-username/booking-service?style=social" alt="Stars"></a>
  <a href="https://github.com/your-username/booking-service"><img src="https://img.shields.io/github/license/your-username/booking-service" alt="License"></a>
</p>

## Booking Service – سیستم رزرو رویداد

یک سیستم رزرو رویداد کامل و مدرن ساخته‌شده با **Laravel 11**، پنل مدیریت حرفه‌ای **Filament 3**، دیتابیس **MySQL**، کش **Redis** و احراز هویت امن API با **Laravel Sanctum**.

کاربران می‌توانند از طریق API ثبت‌نام کنند، وارد شوند، رویدادها را مشاهده کنند، رزرو انجام دهند و رزروهای خود را مدیریت کنند.  
ادمین‌ها هم از طریق پنل زیبا و قدرتمند Filament می‌توانند کاربران، رویدادها و رزروها را به‌طور کامل مدیریت کنند.

### ویژگی‌های اصلی

- ثبت‌نام و ورود کاربر از طریق API
- احراز هویت توکن‌بیس با Laravel Sanctum
- مشاهده لیست رویدادها همراه با تعداد رزروهای فعلی
- رزرو رویداد با چک ظرفیت و جلوگیری از رزرو تکراری
- مشاهده و لغو رزروهای شخصی
- پنل مدیریت کامل با Filament 3:
  - مدیریت کاربران، رویدادها و رزروها
  - مشاهده رزروهای هر کاربر مستقیماً در صفحه ویرایش کاربر
- محیط توسعه کاملاً داکرایز شده با Laravel Sail (MySQL + Redis)

## تکنولوژی‌های استفاده‌شده

- Laravel 11
- Filament 3 (پنل مدیریت)
- Laravel Sanctum (احراز هویت API)
- MySQL
- Redis
- Laravel Sail (Docker)

## پیش‌نیازها

- Docker و Docker Compose
- Git

## نصب و راه‌اندازی

```bash
git clone https://github.com/your-username/booking-service.git
cd booking-service

cp .env.example .env

./vendor/bin/sail up -d

./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate

# (اختیاری) سید داده‌های نمونه
./vendor/bin/sail artisan db:seed --class=EventSeeder

# ساخت کاربر ادمین برای پنل Filament
./vendor/bin/sail artisan make:filament-user
