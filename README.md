# Backend Engineer Technical Tests

## Description

You are given tasks by client to create a simple CRM to manage employees by their companies.

## Prerequisites

-   PHP >= 8.2
-   Composer 2.7.x
-   Laravel >= 11.x
-   Database (MySQL, PostgreSQL, etc.)

## Getting Started

Follow these steps to set up and run the application locally.

### 1. Clone the Repository

Clone the repository to your local machine using Git:

```bash
git clone https://github.com/febryars33/simple-crm.git
cd simple-crm
```

### 2. Install Dependencies

Use Composer to install the required dependencies:

```bash
composer install
```

### 3. Rename .env.example

Copy the .env.example file to .env:

```bash
cp .env.example .env
```

### 4. Generate Application Key

Generate the application key:

```bash
php artisan key:generate
```

### 5. Run Migrations

Run the migrations to set up the database:

```bash
php artisan migrate
```

### 6. Seed the Database

Seed the database with initial data:

```bash
php artisan db:seed
```

### 7. Serve the Application

Serve the application locally:

```bash
php artisan serve
```

Open your browser and navigate to http://localhost:8000.

### 8. Run Tests

Run the tests to ensure everything is working correctly:

```bash
php artisan test
```

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
