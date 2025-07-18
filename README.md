# CRM-system

# Simple CRM API (Laravel Sanctum)

A mini CRM system built with Laravel 10, Sanctum, and REST API principles.  
Admin users can manage leads and assign them to sales agents.

## 🔧 Tech Stack
- Laravel 10
- Sanctum (API Auth)
- MySQL
- Job Queues
- PHPUnit (optional)

## 👥 User Roles
- **Admin:** Full control (CRUD, assign, logs)
- **Sales Agent:** Only manage assigned leads

## 🔐 Authentication
Login via `/api/login` with:
json
{
  "email": "admin@example.com",
  "password": "password"
}

##I will give you some commands for it which is required to run
php artisan queue:work






