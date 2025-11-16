# Daily Expense Tracker (Laravel 10)

A super simple, beginner-friendly API built with **Laravel 10** for tracking personal expenses. There is **no login**, **no authentication**, and just **one database table** (`expenses`). Perfect for quick demos, Laragon/XAMPP setups, or university presentations.

## Requirements
- PHP 8.1+
- Composer
- MySQL (or MariaDB)
- Laravel CLI

## Installation
```bash
# 1. Install dependencies
composer install

# 2. Copy environment file
cp .env.example .env

# 3. Generate application key
php artisan key:generate

# 4. Create the database (MySQL)
#   name: expenses_db
#   charset: utf8mb4

# 5. Update .env with your database credentials
#    DB_DATABASE=expenses_db

# 6. Run migrations to create the expenses table
php artisan migrate

# 7. Start the local server
php artisan serve
```

The API will be available at `http://127.0.0.1:8000`.

## Database Structure
The migration creates a single table named `expenses`.

| Field      | Type          | Notes        |
| ---------- | ------------- | ------------ |
| id         | bigint auto   | Primary key  |
| title      | string        | Required     |
| amount     | decimal(10,2) | Required     |
| category   | string        | Optional     |
| date       | date          | Required     |
| created_at | timestamp     | Generated    |
| updated_at | timestamp     | Generated    |

## API Routes
All routes are defined in `routes/web.php` and return JSON.

| Method | Endpoint               | Description          |
| ------ | ---------------------- | -------------------- |
| POST   | `/expenses/create`     | Create a new expense |
| GET    | `/expenses/all`        | List all expenses    |
| DELETE | `/expenses/delete/{id}`| Delete an expense    |

### 1. Create Expense
`POST http://127.0.0.1:8000/expenses/create`

**Body (JSON or form data)**
```json
{
  "title": "Lunch",
  "amount": 12.50,
  "category": "Food",
  "date": "2024-01-10"
}
```
**Validation**: `title`, `amount`, and `date` are required. `category` is optional.

### 2. Get All Expenses
`GET http://127.0.0.1:8000/expenses/all`

**Response Example**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "title": "Lunch",
      "amount": "12.50",
      "category": "Food",
      "date": "2024-01-10",
      "created_at": "2024-01-10T04:00:00.000000Z",
      "updated_at": "2024-01-10T04:00:00.000000Z"
    }
  ]
}
```

### 3. Delete Expense
`DELETE http://127.0.0.1:8000/expenses/delete/1`

**Response Example**
```json
{
  "status": "success",
  "message": "Expense deleted successfully."
}
```

## Thunder Client / Postman Samples
1. **Create**: POST request with body shown above.
2. **List**: GET request to `/expenses/all`.
3. **Delete**: DELETE request to `/expenses/delete/{id}`.

Set `Content-Type: application/json` for POST requests. No headers or tokens are needed.

## Notes
- This project intentionally keeps everything minimal.
- There is no authentication, middleware, or extra packages.
- Feel free to customize the `category` values or add seed data for demos.
