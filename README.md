# Suziria Test Project

A minimal PHP 8.2+ REST API for managing products, built without frameworks like Laravel or Symfony.  
Features request validation via custom PHP attributes, DTOs, and repository pattern. Includes automated DB setup and tests via Docker.

## 🧱 Stack

- PHP 8.2+
- PostgreSQL 15
- Docker & Docker Compose
- Composer
- PHPUnit
- Guzzle (for integration testing)

---

## 🚀 Quick Start

### 1. Clone the repository

```bash
git clone https://github.com/pkolesnikov/suziria-test.git
cd suziria-test
```

### 2.  Install dependencies:
```bash
composer install
```

### 3. Start the application

```bash
docker compose up --build
```

This will:

- Install all PHP dependencies via Composer
- Run DB migrations and seed 20 products
- Start Apache server on [http://localhost:8080](http://localhost:8080)

---

## 🧪 Run Tests

To execute all tests manually:

```bash
docker compose exec app composer test
```

You will see unit + integration test results.

---

## 📦 API Endpoints

| Method | Endpoint         | Description         |
|--------|------------------|---------------------|
| GET    | `/products`      | List all products   |
| GET    | `/products/{id}` | Get product by ID   |
| POST   | `/products`      | Create product      |
| PUT    | `/products/{id}` | Update product      |
| DELETE | `/products/{id}` | Delete product      |

JSON format expected. Attributes is a nested JSON object.

---

## 🧩 Features Used

- Custom PHP Attributes for validation:
  - `#[Required]`
  - `#[MinLength]`
  - `#[IsNumeric]`
  - etc.

- DTO classes for typed input validation
- PDO for database access
- Repository pattern for database logic
- Strict typing, readonly properties, match/case, enums (PHP 8.2+)

---

## ✅ Done According to Test Task

- [x] Docker setup
- [x] RESTful CRUD
- [x] DB schema & seed
- [x] Custom Attributes
- [x] DTOs
- [x] Repository Pattern
- [x] Unit & Integration Tests
- [x] No frameworks used

---

## ⚙️ Environment Variables

Set in `.env` (already included by Docker):

```
DB_HOST=db
DB_PORT=5432
DB_NAME=suziria
DB_USER=user
DB_PASS=password
```

---

MIT License.
