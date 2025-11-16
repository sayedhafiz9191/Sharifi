# Attendance System

A complete attendance tracking platform built with **Laravel 10 API** (backend) and vanilla **HTML/CSS/JavaScript** (frontend). Authentication is powered by Laravel Sanctum and the system exposes endpoints for registering, logging in, logging out, checking in/out, and viewing attendance history.

## Features
- Token-based authentication (Laravel Sanctum)
- Attendance tracking with one check-in/check-out per day per user
- REST API responses formatted as JSON
- Bootstrap powered frontend (login, register, dashboard, history)
- Reusable JavaScript API helper for calling the backend

## Tech Stack
- PHP 8.1+
- Laravel 10
- MySQL 8+
- Laravel Sanctum
- Bootstrap 5, Vanilla JS

---

## Installation Guide

### 1. Backend (Laravel API)
1. **Install dependencies**
   ```bash
   cd attendance-system
   composer install
   ```
2. **Environment file**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. **Configure database** – update `.env` with your MySQL credentials:
   ```env
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=attendance_system
   DB_USERNAME=root
   DB_PASSWORD=secret
   ```
4. **Run migrations**
   ```bash
   php artisan migrate
   ```
5. **Serve the API**
   ```bash
   php artisan serve
   ```
   The API will be available at `http://127.0.0.1:8000`.

### 2. Frontend (Static files)
1. Serve the static files located in `attendance-system/frontend` using any HTTP server (Live Server, VS Code, or even `php -S`):
   ```bash
   cd attendance-system/frontend
   php -S 127.0.0.1:5500
   ```
2. Open `http://127.0.0.1:5500/login.html` in your browser.

> **Note:** The frontend expects the API to be running on `http://127.0.0.1:8000`. Update `frontend/api.js` if you need a different base URL.

---

## Running Backend & Frontend Together
1. Start the Laravel API using `php artisan serve` (default port 8000).
2. Serve the frontend folder on another port (e.g., 5500).
3. Register a new account, login, and begin using the dashboard to check-in/out and view history.

---

## API Reference

| Method | Endpoint | Description |
| ------ | -------- | ----------- |
| POST   | `/api/register` | Create a new user (`name`, `email`, `password`). Returns `status` + `token`.
| POST   | `/api/login` | Obtain a Sanctum token. Returns `status` + `token`.
| POST   | `/api/logout` | Revoke the current token (requires `Authorization: Bearer`).
| POST   | `/api/attendance/checkin` | Record today's check-in. Enforces one check-in per day.
| POST   | `/api/attendance/checkout` | Record today's check-out. Requires an existing check-in.
| GET    | `/api/attendance/history` | List all attendance entries for the authenticated user.

### Sample Thunder Client / Postman Request
**POST** `http://127.0.0.1:8000/api/login`
```json
{
  "email": "user@example.com",
  "password": "secret123"
}
```
Headers:
```
Content-Type: application/json
```

**Authorized request example** (Check-In)
```
POST http://127.0.0.1:8000/api/attendance/checkin
Authorization: Bearer <token>
```

---

## SQL Preview
```sql
CREATE TABLE `attendances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `check_in` time NULL,
  `check_out` time NULL,
  `created_at` timestamp NULL,
  `updated_at` timestamp NULL,
  UNIQUE KEY `attendances_user_id_date_unique` (`user_id`,`date`),
  CONSTRAINT `attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);
```

---

## Folder Structure
```
attendance-system/
├── app/
├── bootstrap/
├── config/
├── database/
├── frontend/
│   ├── api.js
│   ├── dashboard.html
│   ├── history.html
│   ├── login.html
│   └── register.html
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
└── README.md
```

---

## Thunder Client Collection (Quick Steps)
1. Create a new collection named **Attendance System**.
2. Add the endpoints listed above with the appropriate method and URL.
3. For protected routes, set the `Authorization` header to `Bearer {{token}}`.
4. After calling `/api/login`, copy the returned `token` into a collection variable named `token` so it can be reused.

---

## Tips
- Use strong passwords; validation enforces minimum 8 characters.
- If you need to reset the system quickly, run `php artisan migrate:fresh`.
- To pre-populate demo users, add them inside `database/seeders/DatabaseSeeder.php` and run `php artisan db:seed`.

Happy coding!
