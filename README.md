# 🧪 Suziria Test Project

A demo PHP + PostgreSQL REST API project, ready to run with Docker Compose.  
Includes automatic database setup, seeding, and tests.

---

## 🚀 Tech Stack

- PHP 8.2
- PostgreSQL 15
- Apache (mod_php)
- Composer
- Guzzle (HTTP client)
- PHPUnit (testing)
- Docker + Docker Compose

---

## 📁 Project Structure

```
suziria-test/
├── docker-compose.yml
├── Dockerfile
├── .env
├── composer.json
├── composer.lock
├── phpunit.xml
├── public/                 # Entry point: index.php
├── src/
│   ├── Controller/
│   ├── Repository/
│   ├── DTO/
│   ├── Database.php
│   └── setup.php          # migration + seeding
├── tests/
│   ├── Integration/
│   └── Unit/
└── vendor/
```

---

## ⚙️ Setup & Run

1. **Clone the repository:**

```bash
git clone https://github.com/your-username/suziria-test.git
cd suziria-test
```

2. **Start from scratch:**

```bash
docker compose down -v
docker compose up --build -d
```

3. **Run setup manually (if needed):**

```bash
docker compose exec app php ../src/setup.php
```

4. **Run tests:**

```bash
docker compose exec app composer test
```

---

## 🧱 Composer Commands

| Command             | Description                       |
|---------------------|-----------------------------------|
| `composer install`  | Install dependencies              |
| `composer setup`    | Run migrations and seed database  |
| `composer test`     | Run PHPUnit tests                 |

---

## 🧪 API Endpoints

| Method | Path              | Description            |
|--------|-------------------|------------------------|
| GET    | `/products`       | Get all products       |
| POST   | `/products`       | Create new product     |
| GET    | `/products/{id}`  | Get product by ID      |
| PUT    | `/products/{id}`  | Update product by ID   |
| DELETE | `/products/{id}`  | Delete product by ID   |

Each product includes a JSON `attributes` field with custom key-value pairs.

---

## 📬 Example Product (JSON)

```json
{
  "name": "iPhone 15",
  "price": 999.99,
  "category": "electronics",
  "attributes": {
    "brand": "Apple",
    "color": "black"
  }
}
```

---

## ✅ Automation

When Docker builds:

- Database is migrated
- Products are seeded (if empty)
- App is ready out of the box

---

## 📬 Feedback

Feel free to create [issues](https://github.com/your-username/suziria-test/issues) or reach out directly with suggestions or bugs.