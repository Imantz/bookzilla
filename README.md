## Docker & Docker Compose Setup Guide

### Prerequisites
Make sure you have Docker and Docker Compose installed.

### Setup Instructions

### 1. Clone the repository
```sh
git clone https://github.com/Imantz/bookzilla.git && cd bookzilla && cp .env.example .env
```

### 2. Install dependencies
```sh
npm install && composer install
```

### 3. Generate APP_KEY
```sh
php artisan key:generate
```

### 4. Run Docker Compose
This will build containers, generate key, run migrations, and seed the database.
```sh
docker compose -f compose.dev.yaml up -d
```

### 5. After successful build
```sh
npm run dev
```

#### List containers
```sh
docker ps 
```

You should see 4 containers running:
- bookzilla-web-1
- bookzilla-php-fpm-1
- bookzilla-workspace-1
- bookzilla-postgres-1

#### View logs
```sh 
docker logs bookzilla-php-fpm-1
```

## Links
View your app at:
http://localhost/books

API endpoint to get top 10 books for February:
http://localhost/api/v1/books?sort_by=purchases&sort_order=desc&date_from=2025-02-01&date_to=2025-02-28&limit=10

Example response:
```json
[
  {
    "id": 6,
    "title": "Dolores quae quo quia rerum qui molestiae.",
    "purchases": 2,
    "total_purchases": 7,
    "authors": [
      {
        "id": 18,
        "name": "Mr. Jarrell Murazik",
        "pivot": {
          "book_id": 6,
          "author_id": 18
        }
      },
      {
        "id": 30,
        "name": "Keara Herman",
        "pivot": {
          "book_id": 6,
          "author_id": 30
        }
      }
    ]
  },
  ...
]
```

![alt text](image.png)
