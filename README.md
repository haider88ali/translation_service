#  Laravel Translation Management Service

A Laravel-powered API for managing multilingual translations with support for tagging, search, and export. Designed for modern applications that require scalable, token-authenticated translation handling.

---

##  Features

- **Token-based authentication** using Laravel Sanctum
-  **CRUD operations** for translations
-  **Service Repository Pattern** for modularity and maintainability
-  **Multi-locale support**
-  **Tag-based filtering**
-  **Search** by key, content, or tag
-  **JSON export** by locale
-  **Swagger Api** documentation
-  **Unit and TranslationServiceTest**

---

### Design Pattern

I have use Service Repository Pattern that separates business logic from data access concerns, promoting modularity and maintainability. It involves two main layers: a Service layer that handles business logic and a Repository layer that manages data access. This separation allows for better code organization, easier testing, and improved flexibility in adapting to changes in either the business logic or data storage mechanism


### Requirements
PHP 8.1+

Composer installed

MySQL/PostgreSQL


## 🛠️ Setup Instructions


### 1. Clone the repository

    git clone https://github.com/your-username/translation-api.git

    cd translation-api

### 2. Install dependencies

    composer install

### 3. Create .env file

    cp .env.example .env

### 4. Generate app key

    php artisan key:generate

### 5. Run migrations

    php artisan migrate

### 6. Publish Sanctum config

    php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

### 7. Seed 

    php artisan db:seed

### 8. Serve the application

    php artisan serve


### Authentication
All API routes under /api/translations/* are protected by token-based auth.

🔑 Login

    POST /api/login

    For authentication token use this credentials in api/login api in swagger
    {
    "email": "admin@example.com",
    "password": "password"
    }

    after login you will get token which you will use in all other api's

    {
    "token": "your-api-token"
    }


##  Unit Testing

To verify core functionality, especially for translations, run:

    php artisan test --filter=TranslationServiceTest


###   Swagger API Docs

    php artisan l5-swagger:generate

    http://127.0.0.1:8000/api/documentation

    Use the "Authorize" button to provide your token in Swagger UI:

    Bearer your-api-token








